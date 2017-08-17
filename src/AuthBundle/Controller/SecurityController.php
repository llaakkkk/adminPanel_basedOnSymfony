<?php

// src/AuthBundle/Controller/SecurityController.php
namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
//    /**
//     * @Route("/login", name="login")
//     */
//    public function loginAction(Request $request, AuthenticationUtils $authUtils)
//    {
//        // get the login error if there is one
//        $error = $authUtils->getLastAuthenticationError();
//
//        // last username entered by the user
//        $lastUsername = $authUtils->getLastUsername();
//
//        return $this->render('default/login.html.twig', array(
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//            'last_username' => $lastUsername,
//            'error'         => $error,
//        ));
//    }
}