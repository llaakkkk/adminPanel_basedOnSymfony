<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.17
 * Time: 17:46
 */

namespace MarketingBundle\Utils;

use Doctrine\ORM\EntityManager;
use MarketingBundle\Repository\BillingDataRepository;

class FunnelReport
{

    /**
     * @Var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getDataForReport($filter)
    {
        $repository =  $this->em->getRepository('UserBundle:UserDevices');

//        $GA = new GoogleReportingAPI('7daysAgo', 'today');
        $GA = new GoogleReportingAPI($filter['date-from'], $filter['date-to']);

        $metrics = [
            'traffic' => 'ga:newUsers',
            'downloads' => 'ga:goal18Starts',
            'installs' => 'ga:goal7Starts'
        ];

        $gaReport = $GA->getMetricsData($metrics);

//        var_dump($repository);die;
        $subscriptionMonths = $repository->getSubscriptionsCountByName('month', $filter);
        $subscriptionYear = $repository->getSubscriptionsCountByName('year', $filter);
        $trafficToDownloads = round(($gaReport['downloads'] / $gaReport['traffic']) * 100, 2);
        $trafficToInstalls = round(($gaReport['installs'] / $gaReport['traffic']) * 100, 2);
        $trafficToMonthSubscription = round(($subscriptionMonths['sub_count'] / $gaReport['traffic']) * 100, 2);
        $trafficToYearSubscription = round(($subscriptionYear['sub_count'] / $gaReport['traffic']) * 100, 2);
        $installsToMonthSubscription = round(($subscriptionMonths['sub_count'] / $gaReport['installs']) * 100, 2);
        $installsToYearSubscription = round(($subscriptionYear['sub_count'] / $gaReport['installs']) * 100, 2);

        return [
            'gaReport' => $gaReport,
            'subscriptionMonths' => $subscriptionMonths['sub_count'],
            'subscriptionYear' => $subscriptionYear['sub_count'],
            'trafficToDownloads' => $trafficToDownloads,
            'trafficToInstalls' => $trafficToInstalls,
            'trafficToMonthSubscription' => $trafficToMonthSubscription,
            'trafficToYearSubscription' => $trafficToYearSubscription,
            'installsToMonthSubscription' => $installsToMonthSubscription,
            'installsToYearSubscription' => $installsToYearSubscription
            ];
    }
}