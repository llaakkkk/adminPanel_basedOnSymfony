<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.08.17
 * Time: 15:24
 */

namespace AuthBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('_username')
            ->add('_password', PasswordType::class);
    }


}