<?php

namespace AdminBundle\DataFixtures\ORM;

use AdminBundle\Entity\AdminUser;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAdminUserData implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */

    public function load(ObjectManager $manager)
    {
        $user = new AdminUser();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
//        $user->setPassword('123');

        $encoder = $this->container->get('security.password_encoder');

        $plainPassword = '123';
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
        $logger = $this->container->get("logger");
//        $logger->critical(var_dump($encoder));
//        $logger->critical($encoded);
//        $password = $encoder->encodePassword($user, '123');
//        $user->setPassword($password);
        $user->setRole('admin');


        $manager->persist($user);
        $manager->flush();

    }

    /**
     * Sets the container
     *
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}