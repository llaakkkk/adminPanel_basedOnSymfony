<?php

namespace AdminBundle\Form;

use AdminBundle\Entity\AdminUser;
use AdminBundle\Entity\RolePermissions;
use AdminBundle\Entity\Roles;
use AdminBundle\Repository\AdminUserRepository;
use AdminBundle\Repository\RolesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class EditAdminForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = [];
        foreach ($options['roles'] as $role) {
            $code = $role->getRoleName();
            $choices[$code] = $code;
        }

        $builder
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('roles', ChoiceType::class, array(
               'choices'           => $choices,
                'data' => $options['role']))
            ->add('isActive', CheckboxType::class, array(
            'label'    => 'Active user?',
            'required' => false))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdminUser::class,
            'validation_groups' => ['Admin', 'Edit'],
            'roles' => null,
            'role' => null
        ]);

    }
}