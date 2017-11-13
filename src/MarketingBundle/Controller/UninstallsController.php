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
use Symfony\Component\HttpFoundation\StreamedResponse;

class UninstallsController extends Controller
{

    /**
     * @Route("/uninstalls", name="uninstalls_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uninstallsAction(Request $request)
    {
        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());
        $em = $this->getDoctrine()->getManager('default');

        $osVersions = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByOSVersion();
        $languages = $em->getRepository('UserBundle:Languages')->findAll();
        //todo country
        $modelName = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByModelName();

        $uninstalls = $em->getRepository('UserBundle:UserDevices')->getUninstallsReportData($query);
//var_dump($uninstalls);

        return $this->render('MarketingBundle:Uninstalls:uninstalls_reports.html.twig', [
            'query' => $query,
            'dateFrom' => $query['date-from'],
            'dateTo' => $query['date-to'],
            'osVersions' => $osVersions,
            'languages' => $languages,
            'modelName' => $modelName,
            'uninstalls' => $uninstalls

        ]);
    }

    /**
     * @Route("/uninstalls_report", name="uninstalls_report")
     */
    public function uninstallsReportAction()
    {
        $query = [];
        #
        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to'] : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');
        $uninstalls = $em->getRepository('UserBundle:UserDevices')->getUninstallsReportData($query);

        $response = new StreamedResponse();

        $response->setCallback(function () use (&$uninstalls) {

            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Activation key', 'License', 'Message', 'Build',
                'Date'], ';');

            foreach ($uninstalls as $uninstall) {
                $dataToSave = [$uninstall['activation_key'], $uninstall['license_type_name'],
                    '-', $uninstall['application_build_version'],$uninstall['last_date']];
                fputcsv($handle, $dataToSave, ';');

            }

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="uninstalls_report-'. date('c').'".csv"');

        return $response;


    }


}