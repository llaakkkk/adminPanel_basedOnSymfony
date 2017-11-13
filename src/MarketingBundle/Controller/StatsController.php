<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.17
 * Time: 14:52
 */

namespace MarketingBundle\Controller;

use MarketingBundle\Utils\GoogleReportingAPI;
use MarketingBundle\Utils\FunnelReport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            $avgMonthlyRebills= ($monthlyRebills['user_count'] / $users['user_count']);
            $avgYearlyRebills = ($yearlyRebills['user_count'] / $users['user_count']);
            $averageCheck = ($revenue['revenue'] / $users['user_count']);

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
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function statsReportAction(Request $request)
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

        $dataToSave = [$gaReport['installs'], $subscriptionMonths['sub_count'],
            $subscriptionYear['sub_count'], $revenue['revenue']];


        $response = new StreamedResponse();

        $response->setCallback(function () use (&$dataToSave) {

            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Installs', '1 Month', '1 Year', 'Revenue'], ';');

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function statsRevenueReportAction(Request $request)
    {

        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');

        $revenue = $em->getRepository('MarketingBundle:BillingData')->getUserRevenueByDate($query);

        $refunds = $em->getRepository('MarketingBundle:BillingData')->getUserRefundsByDate($query);
        $usersWithRefunds = $em->getRepository('MarketingBundle:BillingData')->getUserRefundsCountByDate($query);
        $users = $em->getRepository('MarketingBundle:BillingData')->getUserCountByDate($query);
        $monthlyRebills = $em->getRepository('MarketingBundle:BillingData')->getUserRebillsCountByDate('month', $query);
        $yearlyRebills = $em->getRepository('MarketingBundle:BillingData')->getUserRebillsCountByDate('year', $query);



        if ($users['user_count']) {
            $refundsPercent = ($usersWithRefunds['user_count'] / $users['user_count']) * 100;
            $avgMonthlyRebills= ($monthlyRebills['user_count'] / $users['user_count']);
            $avgYearlyRebills = ($yearlyRebills['user_count'] / $users['user_count']);
            $averageCheck = ($revenue['revenue'] / $users['user_count']);
        } else {
            $refundsPercent = 0;
            $avgMonthlyRebills = 0;
            $avgYearlyRebills = 0;
            $averageCheck = 0;
        }

        $dataToSave = [ $revenue['revenue'], $refunds['refund'] .', '. $refundsPercent,
            '-', $avgMonthlyRebills, $avgYearlyRebills, $averageCheck];

        $response = new StreamedResponse();

        $response->setCallback(function () use (&$dataToSave) {

            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Revenue', 'Refunds $, %', 'Discounts $, %',
                'Avg. Rebills Monthly',
                'Avg. Rebills Yearly', 'Average check'], ';');

            fputcsv($handle, $dataToSave, ';');

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="funnel_report-'. date('c').'".csv"');

        return $response;
    }
}