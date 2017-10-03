<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.17
 * Time: 14:35
 */

namespace UserBundle\Repository;

use \Doctrine\ORM\EntityRepository;

class UserDevicesRepository extends EntityRepository
{

    public function getUserDevicesByUserId($userId)
    {
        return $this->createQueryBuilder('u')
            ->where('u.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

}