<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\AdminUser;
use AdminBundle\Entity\Permissions;
use AdminBundle\Entity\RolePermissions;
use AdminBundle\Entity\Roles;
use AdminBundle\Form\EditAdminForm;
use AdminBundle\Repository\AdminUserRepository;
use AdminBundle\Repository\RolePermissionsRepository;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Role\Role;

/**
 * Class AdminController
 * @package AdminBundle\Controller
 * @Security("is_granted('ROLE_SUPPORT')")
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

        return $this->render('AdminBundle:Admin:index.html.twig', [
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
        $repository = $this->getDoctrine()->getRepository(AdminUser::class, 'admin');

        $adminUsers = $repository->findAll();

        return $this->render('AdminBundle:Admin:administrator.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'adminUsers' => $adminUsers
        ]);

    }

    /**
     * @Route("/administrator/{id}/edit", name="administrator_edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administratorEditAction(Request $request,AdminUser $adminUser)
    {

        $em = $this->getDoctrine()->getManager('admin');
        $roles = $em->getRepository('AdminBundle:Roles')->findAll();
        $role =  $adminUser->getRoles()[0];

        $form = $this->createForm(EditAdminForm::class, $adminUser, [
                'roles' => $roles,
                'role' => $role
            ]);

        $form->handleRequest($request);

        if ( $form->isValid()) {

            // Create the user
            /** @var AdminUser $user */
            $adminUser = $form->getData();

            $em->merge($adminUser);
            $em->flush();

            $this->addFlash('success', 'Info saved for '.$adminUser->getEmail());

            return $this->redirectToRoute('administrator');

        }

        return $this->render('AdminBundle:Admin:administrator_edit.html.twig', array(
            'form' => $form->createView()
        ));

    }


    /**
     * @Route("/role_permission", name="role_permission")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rolePermissionAction(Request $request)
    {
        $repositoryRoles = $this->getDoctrine()->getRepository(Roles::class, 'admin');
        $roles = $repositoryRoles->findAll();

        $repositoryPermissions = $this->getDoctrine()->getRepository(Permissions::class, 'admin');
        $permissions = $repositoryPermissions->findAll();

        $repositoryRolesPermissions = $this->getDoctrine()->getRepository(RolePermissions::class,'admin');

        // replace this example code with whatever you need
        return $this->render('AdminBundle:Admin:role_permission.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'permissions' => $permissions,
            'roles' => $roles,
            'rep' => $repositoryRolesPermissions
        ]);

    }

    /**
     * @Route("/role_permission/{roleId}/edit", name="role_permission_edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rolePermissionEditAction(Request $request,Role $role)
    {

//        $em = $this->getDoctrine()->getManager();
//        $roles = $em->getRepository('AdminBundle:Roles')->findAll();
//        $role =  $adminUser->getRoles()[0];
//
//        $form = $this->createForm(EditAdminForm::class, $adminUser, [
//            'roles' => $roles,
//            'role' => $role
//        ]);
//
//        $form->handleRequest($request);
//
//        if ( $form->isValid()) {
//
//            // Create the user
//            /** @var AdminUser $user */
//            $adminUser = $form->getData();
//
//            $em->merge($adminUser);
//            $em->flush();
//
//            $this->addFlash('success', 'Info saved for '.$adminUser->getEmail());
//
//            return $this->redirectToRoute('administrator');
//
//        }
//
//        return $this->render('AdminBundle:Admin:administrator_edit.html.twig', array(
//            'form' => $form->createView()
//        ));

    }

}
