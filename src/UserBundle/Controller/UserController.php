<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Users;
use UserBundle\Repository\UserRepository;

class UserController extends Controller
{
    /**
     * @Route("/user", name="users_list")
     */
    public function usersListAction()
    {
        $repository = $this->getDoctrine()->getRepository('UserBundle:UserDevices', 'default');

        $users = $repository->findAll();

        return $this->render('UserBundle:User:users_list.html.twig', [
            'users' => $users
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
