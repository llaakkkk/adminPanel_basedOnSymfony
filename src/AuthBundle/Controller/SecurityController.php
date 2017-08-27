<?php

// src/AuthBundle/Controller/SecurityController.php
namespace AuthBundle\Controller;

use AdminBundle\Entity\AdminUser;
use AuthBundle\Form\RegistrationForm;
use AuthBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {

        $admin = $this->getUser();
        if ($admin instanceof UserInterface) {
            return $this->redirectToRoute('homepage');
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername
        ]);

        return $this->render('AuthBundle:Login:login.html.twig', array(
            'form' => $form->createView(),

            'error'         => $error,
        ));//
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

        throw new \Exception('this should be reached');
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $form = $this->createForm(RegistrationForm::class);

        $form->handleRequest($request);

        if ( $form->isValid()) {
            // Create the user
            /** @var AdminUser $user */
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getEmail());

            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'

                );

        }

        return $this->render('AuthBundle:Register:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
//
