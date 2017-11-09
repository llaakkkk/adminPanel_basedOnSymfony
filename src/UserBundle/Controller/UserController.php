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

        $dateFrom = isset($query['date_from']) && !empty($query['date_from']) ? $query['date_from'] : date('Y-m-d',strtotime("-7 day"));
        $dateTo = isset($query['date_to']) && !empty($query['date_to']) ? $query['date_to']  : date('Y-m-d', time());

        $em = $this->getDoctrine()->getManager('default');

//        $users = $em->getRepository('UserBundle:UserDevices')->getUserList($query);
        $usersDevices = $em->getRepository('UserBundle:UserDevices')->findAll();

//var_dump($users);die;
        $licensesTypes = $em->getRepository('UserBundle:LicenseTypes')->findAll();
        $billingStatus = $em->getRepository('UserBundle:LicenseStatus')->findAll();
        $appVersions = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByAppVersion();
        $osVersions = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByOSVersion();
        $languages = $em->getRepository('UserBundle:Languages')->findAll();
        $modelName = $em->getRepository('UserBundle:UserDevices')->getUsersDevicesByModelName();


        return $this->render('UserBundle:User:users_list.html.twig', [
            'query' => $query,
            'usersDevices' => $usersDevices,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
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
        $userRepository = $this->getDoctrine()->getRepository('UserBundle:Users', 'default');

        $user = $userRepository->getUserId($id);


        $deviceRepository = $this->getDoctrine()->getRepository('UserBundle:UserDevices', 'default');

        $userDevices = $deviceRepository->getUserDevicesByUserId($id);

        $billingRepository = $this->getDoctrine()->getRepository('MarketingBundle:BillingData', 'default');

        $billingData = $billingRepository->findAll();

//        var_dump($userDevices->getDeviceLanguage());
        return $this->render('UserBundle:User:user.html.twig', [
            'user' => $user,
            'userDevices' => $userDevices,
            'billingData' => $billingData
        ]);
    }


}
