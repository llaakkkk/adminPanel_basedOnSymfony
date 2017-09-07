<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\AdminUser;
use AdminBundle\Entity\Permissions;
use AdminBundle\Entity\RolePermissions;
use AdminBundle\Entity\Roles;
use AdminBundle\Repository\AdminUserRepository;
use AdminBundle\Repository\RolePermissionsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Class AdminController
 * @package AdminBundle\Controller
 * @Security("is_granted('ROLE_MARKETING')")
 */

class AdminController extends Controller
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

        return $this->render('AdminBundle:Admin:administrator.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'adminUsers' => $adminUsers
        ]);

    }

    /**
     * @Route("/role_permission", name="role_permission")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rolePermissionAction(Request $request)
    {
        $repositoryRoles = $this->getDoctrine()->getRepository(Roles::class);
        $roles = $repositoryRoles->findAll();

        $repositoryPermissions = $this->getDoctrine()->getRepository(Permissions::class);
        $permissions = $repositoryPermissions->findAll();

        $repositoryRolesPermissions = $this->getDoctrine()->getRepository(RolePermissions::class);

        // replace this example code with whatever you need
        return $this->render('AdminBundle:Admin:role_permission.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'permissions' => $permissions,
            'roles' => $roles,
            'rep' => $repositoryRolesPermissions
        ]);

    }
}
