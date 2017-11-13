<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.17
 * Time: 14:52
 */

namespace MarketingBundle\Controller;

use MarketingBundle\Utils\GoogleReportingAPI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatsController extends Controller
{

    /**
     * @Route("/stats", name="stats_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statsAction(Request $request)
    {
        $query = $request->query->all();
        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');


        $userDevicesRepository = $em->getRepository('UserBundle:UserDevices');

        $GA = new GoogleReportingAPI('7daysAgo', 'today');
        $metrics = [
            'traffic' => 'ga:newUsers',
            'downloads' => 'ga:goal18Starts',
            'installs' => 'ga:goal7Starts'
        ];
        $gaReport = $GA->getMetricsData($metrics);


        $subscriptionMonths = $userDevicesRepository->getSubscriptionsCountByName('month');
        $subscriptionYear = $userDevicesRepository->getSubscriptionsCountByName('year');

        $billingDataRepository = $this->getDoctrine()->getRepository('MarketingBundle:BillingData', 'default');
        $revenue = $billingDataRepository->getUserRevenueByDate();

        $refunds = $billingDataRepository->getUserRefundsByDate();
        $usersWithRefunds = $billingDataRepository->getUserRefundsCountByDate();
        $users = $billingDataRepository->getUserCountByDate();

        $refundsPercent = ($usersWithRefunds['user_count'] / $users['user_count']) * 100;

        return $this->render('MarketingBundle:Stats:stats_reports.html.twig', [
            'installs' => $gaReport['installs'],
            'subscriptionMonths' => $subscriptionMonths['sub_count'],
            'subscriptionYear' => $subscriptionYear['sub_count'],
            'revenue' => $revenue['revenue'],
            'refunds' => $refunds['refund'],
            'refundsPercent' => $refundsPercent

        ]);
    }

    /**
     * @Route("/stats_report", name="stats_report")
     */
    public function statsReportAction()
    {
        $query = [];
        $dateFrom = isset($query['date_from']) && !empty($query['date_from']) ? $query['date_from'] : date('Y-m-d',strtotime("-7 day"));
        $dateTo = isset($query['date_to']) && !empty($query['date_to']) ? $query['date_to'] : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');
        $funnel = new FunnelReport($em);
        $report = $funnel->getDataForReport($dateFrom, $dateTo, $query);

        $dataToSave = [ $report['gaReport']['traffic'], $report['gaReport']['downloads'],
            $report['gaReport']['installs'],
            $report['subscriptionMonths'],$report['subscriptionYear'], $report['trafficToDownloads'],
            $report['trafficToInstalls'], $report['trafficToMonthSubscription'], $report['trafficToYearSubscription'],
            $report['installsToMonthSubscription'], $report['installsToYearSubscription'] ];

//        var_dump($dataToSave);die;
        $response = new StreamedResponse();

        $response->setCallback(function () use (&$dataToSave) {

            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Traffic', 'Downloads', 'Installs', 'Subscriptions (1 month)',
                'Subscriptions (12 month)', 'Traffic --> Downloads, %',
                'Traffic --> Installs, % ', 'Traffic --> Subscriptions (1 month), %',
                'Traffic --> Subscriptions (12 month), %',
                'Install --> Subscription (1 month), %',
                'Install --> Subscription (12 month), %',
                '1month --> 12 month', 'Revenue' ], ';');

            fputcsv($handle, $dataToSave, ';');

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="funnel_report-'. date('c').'".csv"');

        return $response;
    }

    /**
     * @Route("/stats_revenue_report", name="stats_revenue_report")
     */
    public function statsRevenueReportAction()
    {
        $query = [];
        $dateFrom = isset($query['date_from']) && !empty($query['date_from']) ? $query['date_from'] : date('Y-m-d',strtotime("-7 day"));
        $dateTo = isset($query['date_to']) && !empty($query['date_to']) ? $query['date_to'] : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');
        $funnel = new FunnelReport($em);
        $report = $funnel->getDataForReport($dateFrom, $dateTo, $query);

        $dataToSave = [ $report['gaReport']['traffic'], $report['gaReport']['downloads'],
            $report['gaReport']['installs'],
            $report['subscriptionMonths'],$report['subscriptionYear'], $report['trafficToDownloads'],
            $report['trafficToInstalls'], $report['trafficToMonthSubscription'], $report['trafficToYearSubscription'],
            $report['installsToMonthSubscription'], $report['installsToYearSubscription'] ];

//        var_dump($dataToSave);die;
        $response = new StreamedResponse();

        $response->setCallback(function () use (&$dataToSave) {

            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Traffic', 'Downloads', 'Installs', 'Subscriptions (1 month)',
                'Subscriptions (12 month)', 'Traffic --> Downloads, %',
                'Traffic --> Installs, % ', 'Traffic --> Subscriptions (1 month), %',
                'Traffic --> Subscriptions (12 month), %',
                'Install --> Subscription (1 month), %',
                'Install --> Subscription (12 month), %',
                '1month --> 12 month', 'Revenue' ], ';');

            fputcsv($handle, $dataToSave, ';');

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="funnel_report-'. date('c').'".csv"');

        return $response;
    }
}