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
        $sql = 'SELECT DISTINCT ON (ud.id)
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
            FULL OUTER JOIN license_types lt ON lt.id = psp.license_type_id
            LEFT JOIN languages_to_user_devices lud ON lud.user_device_id = ud.id
            LEFT JOIN languages l ON l.id = lud.language_id
            LEFT JOIN (
            SELECT max(created) as last_billed,
                               order_id,
                               user_device_id,
                               promo_code
                             FROM billing_data
                             GROUP BY (user_device_id,order_id, promo_code)
            ) bd ON bd.user_device_id = ud.id
            WHERE ud.created::date >= :date_from AND ud.created::date <= :date_to
            AND ud.is_hidden = FALSE ';

        $params = array(
            'date_from' => $query['date-from'],
            'date_to'   => $query['date-to']
        );

        if (isset($query['license-type']) && !empty($query['license-type'])) {
            $id_params = array();
            foreach ($query['license-type'] as $i => $id) {
                $name = ":license_type_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND lt.slug IN ('.$id_params.')';
        }

        if (isset($query['billing-status']) && !empty($query['billing-status'])) {
            $id_params = array();
            foreach ($query['billing-status'] as $i => $id) {
                $name = ":billing_status_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND ls.slug IN ('.$id_params.')';
        }

        if (isset($query['app-version']) && !empty($query['app-version'])) {
            $id_params = array();
            foreach ($query['app-version'] as $i => $id) {
                $name = ":app_version_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND ud.application_build_version IN ('.$id_params.')';
        }

        if (isset($query['os-version']) && !empty($query['os-version'])) {
            $id_params = array();
            foreach ($query['os-version'] as $i => $id) {
                $name = ":os_version_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND ud.os_version IN ('.$id_params.')';
        }
        if (isset($query['model-name']) && !empty($query['model-name'])) {
            $id_params = array();
            foreach ($query['model-name'] as $i => $id) {
                $name = ":model_name_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND ud.model_name IN ('.$id_params.')';
        }

        if (isset($query['languages']) && !empty($query['languages'])) {
            $id_params = array();
            foreach ($query['languages'] as $i => $id) {
                $name = ":languages_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND l.slug IN ('.$id_params.')';
        }
        $statement = $this->getEntityManager()->getConnection()->prepare($sql);

        $statement->execute($params);

        $result = $statement->fetchAll();


        return $result;
    }

    public function getUninstallsReportData($query)
    {

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
                    FULL OUTER JOIN license_types lt ON pp.license_type_id = lt.id
                    LEFT JOIN languages_to_user_devices lud ON lud.user_device_id = ud.id
                    LEFT JOIN languages l ON l.id = lud.language_id
                    WHERE ud.updated::date >= :date_from AND ud.updated::date <= :date_to";

        $params = array(
            'date_from' => $query['date-from'],
            'date_to'   => $query['date-to']
        );

        if (isset($query['os-version']) && !empty($query['os-version'])) {
            $id_params = array();
            foreach ($query['os-version'] as $i => $id) {
                $name = ":os_version_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND ud.os_version IN ('.$id_params.')';
        }
        if (isset($query['model-name']) && !empty($query['model-name'])) {
            $id_params = array();
            foreach ($query['model-name'] as $i => $id) {
                $name = ":model_name_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND ud.model_name IN ('.$id_params.')';
        }

        if (isset($query['languages']) && !empty($query['languages'])) {
            $id_params = array();
            foreach ($query['languages'] as $i => $id) {
                $name = ":languages_$i";

                $params[$name] = $id;

                $id_params[] = $name;
            }
            $id_params = implode(', ', $id_params);
            $sql .= ' AND l.slug IN ('.$id_params.')';
        }

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);


        $statement->execute($params);

        $result = $statement->fetchAll();

        return $result;
    }

    public function getFirstSubscriptionDate($date)
    {
        $sql = "SELECT max(ss.created) as date_range
                FROM user_devices ud
                INNER JOIN subscription_status ss ON ss.id = ud.subscription_status_id
                WHERE ss.created::date >= :date_from 
                AND ss.created::date <= :date_to";

        $params = array(
            'date_from' => $date['date-from'],
            'date_to'   => $date['date-to']
        );

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);


        $statement->execute($params);

        $result = $statement->fetch(\PDO::FETCH_COLUMN);
        return $result;
    }

    public function getUsersCountInDate($date)
    {
        $sql = "SELECT count(ud.user_id) as count
                FROM user_devices ud
                INNER JOIN subscription_status ss ON ss.id = ud.subscription_status_id
                WHERE ss.created::date >= :date_from 
                AND ss.created::date <= :date_to";

        $params = array(
            'date_from' => $date['date-from'],
            'date_to'   => $date['date-to']
        );

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);


        $statement->execute($params);

        $result = $statement->fetch(\PDO::FETCH_COLUMN);
        return $result;
    }


    public function setUserInactive($userId)
    {
        $sql = "UPDATE user_devices
                SET is_hidden = true
                WHERE user_id = :user_id";

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);
        $params = ['user_id' => $userId];

        return $statement->execute($params);
    }


}