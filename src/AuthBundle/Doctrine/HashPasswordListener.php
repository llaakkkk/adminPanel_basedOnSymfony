<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.08.17
 * Time: 16:58
 */

namespace AuthBundle\Doctrine;


use AdminBundle\Entity\AdminUser;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class HashPasswordListener implements EventSubscriber
{


    private $passwordEncoder;

    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        if (!$entity instanceof AdminUser) {
          return;
        }

        $this->encodePassword($entity);

    }

    public function preUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        if (!$entity instanceof AdminUser) {
          return;
        }

        $this->encodePassword($entity);
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta,$entity);

    }
    
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * @param AdminUser $entity
     */
    public function encodePassword(AdminUser $entity)
    {
        $encoded = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encoded);
    }
}