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

    public function getUsersDevicesByAppVersion()
    {
        return $this->createQueryBuilder('u')
            ->select('u.applicationBuildVersion')
            ->groupBy('u.applicationBuildVersion')
            ->getQuery()
            ->getResult();
    }

    public function getUsersDevicesByOSVersion()
    {
        return $this->createQueryBuilder('u')
            ->select('u.osVersion')
            ->groupBy('u.osVersion')
            ->getQuery()
            ->getResult();
    }

    public function getUsersDevicesByModelName()
    {
        return $this->createQueryBuilder('u')
            ->select('u.modelName')
            ->groupBy('u.modelName')
            ->getQuery()
            ->getResult();
    }

    public function getSubscriptionsCountByName($licenseType, $typeOfInstall = null)
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

    public function getUserList($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('UserBundle\Repository\UserDevicesRepository', 'ud');
        $rsm->addFieldResult('ud', 'activation_key', 'activation_key');
        $rsm->addFieldResult('ud', 'created', 'created');
        $rsm->addJoinedEntityResult('User', 'u', 'ud', 'user_id');
        $rsm->addFieldResult('u', 'first_name', 'first_name');
        $rsm->addFieldResult('u', 'last_name', 'last_name');
        $rsm->addFieldResult('u', 'email', 'email');
        $rsm->addJoinedEntityResult('SubscriptionStatus', 'ss', 'ud', 'subscription_status_id');
        $rsm->addJoinedEntityResult('LicenseStatus', 'ls', 'ss', 'license_status_id');
        $rsm->addFieldResult('ls', 'name', 'license_status');
        $rsm->addJoinedEntityResult('PaymentSystemProducts', 'psp', 'ss', 'product_id');
        $rsm->addJoinedEntityResult('LicenseTypes', 'lt', 'psp', 'license_type_id');
        $rsm->addFieldResult('lt', 'name', 'license_type');
        $rsm->addJoinedEntityResult('BillingData', 'bd', 'ud', 'id');
        $rsm->addFieldResult('bd', 'last_billed', 'last_billed');
        $rsm->addFieldResult('bd', 'order_id', 'order_id');
        $rsm->addFieldResult('bd', 'promo_code', 'promo_code');


        $qb = $this->getEntityManager()->createNativeQuery("SELECT 
              ud.activation_key,
              ud.created,
              u.first_name,
              u.last_name,
              u.email,
              ls.name AS license_status,
              lt.name AS license_type,
              bd.last_billed,
              bd.order_id,
              bd.promo_code
            FROM user_devices ud
            LEFT JOIN users u ON u.id = ud.user_id
            LEFT JOIN subscription_status ss ON ss.id = ud.subscription_status_id
            INNER JOIN license_status ls ON ls.id = ss.license_status_id
            LEFT JOIN payment_system_products psp ON psp.id = ss.product_id
            INNER JOIN license_types lt ON lt.id = psp.license_type_id
            LEFT JOIN (
                         SELECT max(created) as last_billed,
                           order_id,
                           user_device_id,
                           promo_code
                         FROM billing_data
                         GROUP BY (user_device_id,order_id, promo_code)
            ) bd ON bd.user_device_id = ud.id", $rsm);

//        $qb->setParameter(1, $licenseType);
        $users = $qb->getResult();

        return $users;
    }



}