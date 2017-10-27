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

        $dateFrom = isset($query['date_from']) && !empty($query['date_from']) ? $query['date_from'] : strtotime("-7 day");
        $dateTo = isset($query['date_to']) && !empty($query['date_to']) ? $query['date_to']  : time();

        $repository = $this->getDoctrine()->getRepository('UserBundle:UserDevices', 'default');

        $users = $repository->findAll();

        return $this->render('UserBundle:User:users_list.html.twig', [
            'users' => $users,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
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
