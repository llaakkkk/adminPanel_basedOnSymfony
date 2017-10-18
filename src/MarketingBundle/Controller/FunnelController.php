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
//        $repository = $this->getDoctrine()->getRepository(':UserDevices', 'default');
//
//        $users = $repository->findAll();

        $GA = new GoogleReportingAPI('30daysAgo', 'today');
        $metrics = [
            'traffic' => 'ga:newUsers',
            'downloads' => 'ga:goal18Starts',
            'installs' => 'ga:goal7Starts'
        ];
        $gaReport = $GA->getMetricsData($metrics);

//        var_dump($traffic, $downloads,$installs);

        var_dump($gaReport);
        return $this->render('MarketingBundle:Funnel:funnel_reports.html.twig', [


        ]);
    }
}