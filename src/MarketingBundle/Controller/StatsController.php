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

        $GA = new GoogleReportingAPI($query['date-from'], $query['date-to']);
        $metrics = [
            'traffic' => 'ga:newUsers',
            'downloads' => 'ga:goal18Starts',
            'installs' => 'ga:goal7Starts'
        ];
        $gaReport = $GA->getMetricsData($metrics);


        $subscriptionMonths = $userDevicesRepository->getSubscriptionsCountByName('month', $query);
        $subscriptionYear = $userDevicesRepository->getSubscriptionsCountByName('year', $query);

        $revenue = $em->getRepository('MarketingBundle:BillingData')->getUserRevenueByDate($query);

        $refunds = $em->getRepository('MarketingBundle:BillingData')->getUserRefundsByDate($query);
        $usersWithRefunds = $em->getRepository('MarketingBundle:BillingData')->getUserRefundsCountByDate($query);
        $users = $em->getRepository('MarketingBundle:BillingData')->getUserCountByDate($query);
        $monthlyRebills = $em->getRepository('MarketingBundle:BillingData')->getUserRebillsCountByDate('month', $query);
        $yearlyRebills = $em->getRepository('MarketingBundle:BillingData')->getUserRebillsCountByDate('year', $query);



        if ($users['user_count']) {
            $refundsPercent = ($usersWithRefunds['user_count'] / $users['user_count']) * 100;
            $avgMonthlyRebills= ($monthlyRebills / $users['user_count']);
            $avgYearlyRebills = ($yearlyRebills / $users['user_count']);
            $averageCheck = ($revenue / $users['user_count']);

        } else {
            $refundsPercent = 0;
            $avgMonthlyRebills = 0;
            $avgYearlyRebills = 0;
            $averageCheck = 0;
        }

        return $this->render('MarketingBundle:Stats:stats_reports.html.twig', [
            'query' => $query,
            'installs' => $gaReport['installs'],
            'subscriptionMonths' => $subscriptionMonths['sub_count'],
            'subscriptionYear' => $subscriptionYear['sub_count'],
            'revenue' => $revenue['revenue'],
            'refunds' => $refunds['refund'],
            'refundsPercent' => $refundsPercent,
            'avgMonthlyRebills' => $avgMonthlyRebills,
            'avgYearlyRebills' => $avgYearlyRebills,
            'averageCheck' => $averageCheck
        ]);
    }

    /**
     * @Route("/stats_report", name="stats_report")
     */
    public function statsReportAction(Request $request)
    {

        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');
        $funnel = new FunnelReport($em);
        $report = $funnel->getDataForReport($query);

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
    public function statsRevenueReportAction(Request $request)
    {

        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');
        $funnel = new FunnelReport($em);
        $report = $funnel->getDataForReport($query);

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