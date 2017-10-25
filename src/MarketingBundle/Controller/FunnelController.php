<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.17
 * Time: 14:52
 */

namespace MarketingBundle\Controller;

use MarketingBundle\Services\GoogleReportingAPI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FunnelController extends Controller
{

    /**
     * @Route("/funnel", name="funnel_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function funnelAction(Request $request)
    {


        $query = $request->query->all();

        $dateFrom = isset($query['date_from']) && !empty($query['date_from']) ? $query['date_from'] : strtotime("-7 day");
        $dateTo = isset($query['date_to']) && !empty($query['date_to']) ? $query['date_to']  : time();

        $repository = $this->getDoctrine()->getRepository('UserBundle:UserDevices', 'default');

        $GA = new GoogleReportingAPI('7daysAgo', 'today');
        $metrics = [
            'traffic' => 'ga:newUsers',
            'downloads' => 'ga:goal18Starts',
            'installs' => 'ga:goal7Starts'
        ];
        $gaReport = $GA->getMetricsData($metrics);


        $subscriptionMonths = $repository->getSubscriptionsCountByName('month', $query);
        $subscriptionYear = $repository->getSubscriptionsCountByName('year', $query);
        $trafficToDownloads = round(($gaReport['downloads'] / $gaReport['traffic']) * 100, 2);
        $trafficToInstalls = round(($gaReport['installs'] / $gaReport['traffic']) * 100, 2);
        $trafficToMonthSubscription = round(($subscriptionMonths['sub_count'] / $gaReport['traffic']) * 100, 2);
        $trafficToYearSubscription = round(($subscriptionYear['sub_count'] / $gaReport['traffic']) * 100, 2);
        $installsToMonthSubscription = round(($subscriptionMonths['sub_count'] / $gaReport['installs']) * 100, 2);
        $installsToYearSubscription = round(($subscriptionYear['sub_count'] / $gaReport['installs']) * 100, 2);

        $typesOfInstall = [
            ['name' => 'all', 'title' => 'All'],
            ['name' => 'free-install', 'title' => 'Free install'],
            ['name' => 'paid-install', 'title' => 'Paid install'],
            ['name' => 'paid-users', 'title'=> 'Paid users']
        ];

        return $this->render('MarketingBundle:Funnel:funnel_reports.html.twig', [
            'gaReport' => $gaReport,
            'subscriptionMonths' => $subscriptionMonths['sub_count'],
            'subscriptionYear' => $subscriptionYear['sub_count'],
            'trafficToDownloads' => $trafficToDownloads,
            'trafficToInstalls' => $trafficToInstalls,
            'trafficToMonthSubscription' => $trafficToMonthSubscription,
            'trafficToYearSubscription' => $trafficToYearSubscription,
            'installsToMonthSubscription' => $installsToMonthSubscription,
            'installsToYearSubscription' => $installsToYearSubscription,
            'typesOfInstall' => $typesOfInstall,
            'quered' => $query,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo

        ]);
    }

}