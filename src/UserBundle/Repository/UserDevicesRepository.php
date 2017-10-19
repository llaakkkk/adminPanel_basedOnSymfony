<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.17
 * Time: 14:35
 */

namespace UserBundle\Repository;

use \Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Query\ResultSetMapping;
use \UserBundle\Entity\LanguagesToUserDevices;


class UserDevicesRepository extends EntityRepository
{

    public function getUserDevicesByUserId($userId)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getSubscriptionsCountByName($licenseType)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('sub_count', 'sub_count');

        $qb = $this->getEntityManager()->createNativeQuery("SELECT count(ud.user_id) as sub_count
            FROM user_devices ud
            LEFT JOIN subscription_status ss ON ud.subscription_status_id = ss.id
            INNER JOIN payment_system_products psp ON ss.product_id = psp.id
            INNER JOIN license_types lt ON psp.license_type_id = lt.id
            WHERE lt.slug = ?", $rsm);

        $qb->setParameter(1, $licenseType);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

}