<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Users;
use UserBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;


class UserController extends Controller
{
    /**
     * @Route("/user", name="users_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function usersListAction(Request $request)
    {
        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to']  : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');

        $usersDevices = $em->getRepository('UserBundle:UserDevices')->getUserList($query);

        $licensesTypes = $em->getRepository('UserBundle:LicenseTypes')->findAll();
        $billingStatus = $em->getRepository('UserBundle:LicenseStatus')->findAll();
        $appVersions = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByAppVersion();
        $osVersions = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByOSVersion();
        $languages = $em->getRepository('UserBundle:Languages')->findAll();
        $modelName = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByModelName();


        return $this->render('UserBundle:User:users_list.html.twig', [
            'query' => $query,
            'usersDevices' => $usersDevices,
            'dateFrom' => $query['date-from'],
            'dateTo' => $query['date-to'],
            'licenses' => $licensesTypes,
            'billingStatus' => $billingStatus,
            'appVersions' => $appVersions,
            'osVersions' => $osVersions,
            'languages' => $languages,
            'modelName' => $modelName
        ]);
    }

    /**
     * @Route("/users_report", name="users_report")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function usersReportAction(Request $request)
    {
        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to'] : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');
        $usersDevices = $em->getRepository('UserBundle:UserDevices')->getUserList($query);

        $response = new StreamedResponse();

        $response->setCallback(function () use (&$usersDevices) {

            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Name', 'Email', 'Activation key', 'License',
                'Billing status', 'Created', 'Last billed', 'Order ID', 'Coupon code'], ';');

            foreach ($usersDevices as $usersDevice) {
                $dataToSave = [
                    $usersDevice['user_id'] ? $usersDevice['user_id'] : '-',
                    $usersDevice['email'] ? $usersDevice['email'] : '-',
                    $usersDevice['activation_key'] ? $usersDevice['activation_key'] : '-',
                    $usersDevice['license_type'] ? $usersDevice['license_type'] : '-',
                    $usersDevice['license_status'] ? $usersDevice['license_status'] : '-',
                    $usersDevice['created'] ? $usersDevice['created'] : '-',
                    $usersDevice['last_billed'] ? $usersDevice['last_billed'] : '-',
                    $usersDevice['order_id'] ? $usersDevice['order_id'] : '-',
                    $usersDevice['promo_code'] ? $usersDevice['promo_code'] : '-',
                ];
                fputcsv($handle, $dataToSave, ';');

            }

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="users_report-'. date('c').'".csv"');

        return $response;
    }

    /**
     * @Route("/user/{id}", name="user")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction($id)
    {
        $em = $this->getDoctrine()->getManager('default');

        $user = $em->getRepository('UserBundle:Users')->getUserId($id);

        $userDevices =$em->getRepository('UserBundle:UserDevices')->findBy(['userId' => $id]);

        $billingData = $em->getRepository('MarketingBundle:BillingData')->findBy(['userId' => $id]);


        return $this->render('UserBundle:User:user.html.twig', [
            'user' => $user,
            'userDevices' => $userDevices,
            'billingData' => $billingData
        ]);
    }


}
