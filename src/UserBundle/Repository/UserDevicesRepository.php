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

    public function getSubscriptionsCountByName($licenseType, $filter)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('sub_count', 'sub_count');

        $sql = "SELECT count(ud.user_id) as sub_count
            FROM user_devices ud
            LEFT JOIN subscription_status ss ON ud.subscription_status_id = ss.id
            INNER JOIN payment_system_products psp ON ss.product_id = psp.id
            INNER JOIN license_types lt ON psp.license_type_id = lt.id
            WHERE lt.slug = :license_type AND ud.created >= :date_from AND ud.created <= :date_to";

        $qb = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $qb->setParameter('license_type', $licenseType);
        $qb->setParameter('date_from', $filter['date-from']);
        $qb->setParameter('date_to', $filter['date-to']);
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
        $rsm->addJoinedEntityResult('MarketingBundle:BillingData', 'bd', 'ud', 'billingData');
        $rsm->addFieldResult('bd', 'last_billed', 'created');
        $rsm->addFieldResult('bd', 'order_id', 'orderId');
        $rsm->addFieldResult('bd', 'promo_code', 'promoCode');


        $qb = $this->getEntityManager()->createNativeQuery("
                SELECT 
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


    public function getUserList($query)
    {
        $sql = 'SELECT 
              ud.activation_key,
              ud.created,
              ud.id as user_device_id,
              u.first_name,
              u.last_name,
              u.email,
              u.id as user_id,
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
            ) bd ON bd.user_device_id = ud.id
            WHERE ud.updated > :date_from AND ud.updated < :date_to';

        if (isset($query['license-type']) && !empty($query['license-type'])) {
            $sql .= ' AND lt.slug IN (:license_type)';
        }

        if (isset($query['billing-status']) && !empty($query['billing-status'])) {
            $sql .= ' AND ls.slug IN (:billing_status)';
        }

        if (isset($query['app-version']) && !empty($query['app-version'])) {
            $sql .= ' AND ud.application_build_version IN (:application_build_version)';
        }

        if (isset($query['os-version']) && !empty($query['os-version'])) {
            $sql .= ' AND ud.os_version IN (:os_version)';
        }
        if (isset($query['model-name']) && !empty($query['model-name'])) {
            $sql .= ' AND ud.model_name IN (:model_name)';
        }

        if (isset($query['languages']) && !empty($query['languages'])) {
            $sql .= ' AND l.slug IN (:languages)';
        }
        $statement = $this->getEntityManager()->getConnection()->prepare($sql);

        $statement->bindValue('date_from', $query['date-from'], \PDO::PARAM_STR);
        $statement->bindValue('date_to', $query['date-to'], \PDO::PARAM_STR);

        if (!empty($query['license-type'])) {
            $statement->bindValue('license_type', implode(",", $query['license-type']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        if (!empty($query['billing-status'])) {
            $statement->bindValue('billing_status', implode(",", $query['billing-status']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        if (isset($query['app-version'])) {
            $statement->bindValue('application_build_version', implode(",", $query['app-version']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        if (!empty($query['os-version'])) {
            $statement->bindValue('os_version', implode(",", $query['os-version']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }
        if (!empty($query['model-name'])) {
            $statement->bindValue('model_name', implode(",", $query['model-name']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }
        if (!empty($query['languages'])) {
            $statement->bindValue('languages', implode(",", $query['languages']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }
        $statement->execute();

        $result = $statement->fetchAll();


        return $result;
    }

    public function getUninstallsReportData($query)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT ud.activation_key,
                      ud.user_id,
                      ud.id as device_id,
                      pp.license_type_id,
                      lt.name as license_type_name,
                      lt.slug as license_type_slug,
                      ud.application_build_version,
                      ud.updated as last_date
                    FROM user_devices ud
                    LEFT JOIN subscription_status ss ON ss.id = ud.subscription_status_id
                    INNER JOIN payment_system_products pp ON pp.id = ss.product_id
                    INNER JOIN license_types lt ON pp.license_type_id = lt.id
                    LEFT JOIN languages_to_user_devices lud ON lud.user_device_id = ud.id
                    LEFT JOIN languages l ON l.id = lud.language_id
                    WHERE ud.updated > :date_from AND ud.updated < :date_to";

        if (isset($query['os-version']) && !empty($query['os-version'])) {
            $sql .= ' AND ud.os_version IN (:os_version)';
        }
        if (isset($query['model-name']) && !empty($query['model-name'])) {
            $sql .= ' AND ud.model_name IN (:model_name)';
        }

        if (isset($query['languages']) && !empty($query['languages'])) {
            $sql .= ' AND l.slug IN (:languages)';
        }

        $statement = $em->getConnection()->prepare($sql);

        $statement->bindValue('date_from', $query['date-from'], \PDO::PARAM_STR);
        $statement->bindValue('date_to', $query['date-to'], \PDO::PARAM_STR);

        if (!empty($query['os-version'])) {
            $statement->bindValue('os_version', implode(",", $query['os-version']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }
        if (!empty($query['model-name'])) {
            $statement->bindValue('model_name', implode(",", $query['model-name']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }
        if (!empty($query['languages'])) {
            $statement->bindValue('languages', implode(",", $query['languages']), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }



}