<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Users;
use UserBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;


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

//        $usersDevices = $em->getRepository('UserBundle:UserDevices')->getUserListTest($query);
        $usersDevices = $em->getRepository('UserBundle:UserDevices')->getUserList($query);

//var_dump($usersDevices);die;
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
     * @Route("/user/{id}", name="user")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction($id)
    {
        $em = $this->getDoctrine()->getManager('default');

        $user = $em->getRepository('UserBundle:Users')->getUserId($id);

        $userDevices =$em->getRepository('UserBundle:UserDevices')->findBy(['userId' => $id]);

        $billingData = $em->getRepository('MarketingBundle:BillingData')->findBy(['userId' => $id]);

//        var_dump($userDevices->getDeviceLanguage());
        return $this->render('UserBundle:User:user.html.twig', [
            'user' => $user,
            'userDevices' => $userDevices,
            'billingData' => $billingData
        ]);
    }


}
