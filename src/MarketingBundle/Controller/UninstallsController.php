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

class UninstallsController extends Controller
{

    /**
     * @Route("/uninstalls", name="uninstalls_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statsAction(Request $request)
    {
//        $repository = $this->getDoctrine()->getRepository(':UserDevices', 'default');
//
//        $users = $repository->findAll();

        $userDevicesRepository = $this->getDoctrine()->getRepository('UserBundle:UserDevices', 'default');

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

        return $this->render('MarketingBundle:Uninstalls:uninstalls_reports.html.twig', [
            'installs' => $gaReport['installs'],
            'subscriptionMonths' => $subscriptionMonths['sub_count'],
            'subscriptionYear' => $subscriptionYear['sub_count'],
            'revenue' => $revenue['revenue'],
            'refunds' => $refunds['refund'],
            'refundsPercent' => $refundsPercent

        ]);
    }
}