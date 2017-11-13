<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.17
 * Time: 14:52
 */

namespace MarketingBundle\Controller;

use Doctrine\ORM\EntityManager;
use MarketingBundle\Utils\GoogleReportingAPI;
use MarketingBundle\Utils\FunnelReport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());
        $em = $this->getDoctrine()->getManager('default');

        $funnel = new FunnelReport($em);
        $report = $funnel->getDataForReport($query);

        $typesOfInstall = [
            ['name' => 'all', 'title' => 'All'],
            ['name' => 'free-install', 'title' => 'Free install'],
            ['name' => 'paid-install', 'title' => 'Paid install'],
            ['name' => 'paid-users', 'title'=> 'Paid users']
        ];

        return $this->render('MarketingBundle:Funnel:funnel_reports.html.twig', array_merge(
            $report,
            ['typesOfInstall' => $typesOfInstall,
            'query' => $query]
        ));
    }

    /**
     * @Route("/funnel_report", name="funnel_report")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function funnelReportAction(Request $request)
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