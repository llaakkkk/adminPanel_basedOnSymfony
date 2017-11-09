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

    public function getUserListTest($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('UserBundle:UserDevices', 'ud');
        $rsm->addFieldResult('ud', 'activationName', 'activation_key');
        $rsm->addFieldResult('ud', 'created', 'created');
        $rsm->addJoinedEntityResult('UserBundle:Users', 'u', 'ud', 'userId');
        $rsm->addFieldResult('u', 'firstName', 'first_name');
        $rsm->addFieldResult('u', 'lastName', 'last_name');
        $rsm->addFieldResult('u', 'email', 'email');
        $rsm->addJoinedEntityResult('UserBundle:SubscriptionStatus', 'ss', 'ud', 'subscriptionStatus');
        $rsm->addJoinedEntityResult('UserBundle:LicenseStatus', 'ls', 'ss', 'licenseStatus');
        $rsm->addFieldResult('ls', 'name', 'license_status');
        $rsm->addJoinedEntityResult('MarketingBundle:PaymentSystemProducts', 'psp', 'ss', 'product');
        $rsm->addJoinedEntityResult('UserBundle:LicenseTypes', 'lt', 'psp', 'licenseType');
        $rsm->addFieldResult('lt', 'name', 'license_type');
//        $rsm->addJoinedEntityResult('MarketingBundle:BillingData', 'bd', 'ud', 'billingData');
//        $rsm->addFieldResult('bd', 'last_billed', 'last_billed');
//        $rsm->addFieldResult('bd', 'order_id', 'order_id');
//        $rsm->addFieldResult('bd', 'promo_code', 'promo_code');


        $qb = $this->getEntityManager()->createNativeQuery("
                SELECT 
              ud.activation_key,
              ud.created,
              u.first_name,
              u.last_name,
              u.email,
              ls.name AS license_status,
              lt.name AS license_type
            FROM user_devices ud
            LEFT JOIN users u ON u.id = ud.user_id
            LEFT JOIN subscription_status ss ON ss.id = ud.subscription_status_id
            INNER JOIN license_status ls ON ls.id = ss.license_status_id
            LEFT JOIN payment_system_products psp ON psp.id = ss.product_id
            INNER JOIN license_types lt ON lt.id = psp.license_type_id
            ", $rsm);

//        bd.last_billed,
//              bd.order_id,
//              bd.promo_code
//        LEFT JOIN (
//        SELECT max(created) as last_billed,
//                           order_id,
//                           user_device_id,
//                           promo_code
//                         FROM billing_data
//                         GROUP BY (user_device_id,order_id, promo_code)
//            ) bd ON bd.user_device_id = ud.id
//        $qb->setParameter(1, $licenseType);
        $users = $qb->getResult();

        return $users;
    }


    public function getUserList($query)
    {


        $users = $this->createQueryBuilder('ud')
            ->where('ud.created > :date_from')
            ->setParameter('date_from', $query['date-from'])
            ->andWhere('ud.created < :date_to')
            ->setParameter('date_to', $query['date-to']);

        //            ->groupBy('ud.osVersion')
        //            ->where('m.reciever = ?1')
        //


        if (isset($query['license-type']) && !empty($query['license-type'])) {
            $users->andWhere('ud.userName IN(:license_type)')
                ->setParameter('license_type', array_values($query['license-type']));

        }
        if (isset($query['billing-status']) && !empty($query['billing-status'])) {
            $users->andWhere('ud.subscriptionStatus.licenseStatus.name IN(:license_status)')
                ->setParameter('license_status', array_values($query['billing-status']));

        }

        return $users->getQuery()
            ->getResult();
    }



}