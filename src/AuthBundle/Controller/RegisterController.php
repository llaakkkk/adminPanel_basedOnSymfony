<?php

namespace AuthBundle\Controller;

use AdminBundle\Entity\AdminUser;
use AuthBundle\Form\AdminUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();


        $user = new AdminUser();

        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Create the user
            $user->setPassword($encoder->encodePassword($user, $user->getEmail()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');

        }


        return $this->render('AuthBundle:Register:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
