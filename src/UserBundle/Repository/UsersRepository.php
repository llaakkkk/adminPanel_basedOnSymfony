<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.17
 * Time: 14:35
 */

namespace UserBundle\Repository;

use \Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository
{
    public function getUserId($userId)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }


}