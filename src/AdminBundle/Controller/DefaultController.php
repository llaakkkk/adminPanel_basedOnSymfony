<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\AdminUser;
use AdminBundle\Repository\AdminUserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Class DefaultController
 * @package AdminBundle\Controller
 * @Security("is_granted('ROLE_MARKETING')")
 */

class DefaultController extends Controller
{

    /**
     * @Route("/admin_panel", name="admin_panel")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('AdminBundle:Default:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }


    /**
     * @Route("/administrator", name="administrator")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administratorAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(AdminUser::class);

        $adminUsers = $repository->findAll();
//        var_dump($adminUsers);
        // replace this example code with whatever you need
        return $this->render('AdminBundle:Default:administrator.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'adminUsers' => $adminUsers
        ]);

    }
}
