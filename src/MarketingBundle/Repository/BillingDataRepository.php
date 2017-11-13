<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.10.17
 * Time: 17:05
 */

namespace MarketingBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Query\ResultSetMapping;

class BillingDataRepository extends EntityRepository
{

    //$dateFrom, $dateTo
    public function getUserRevenueByDate($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('revenue', 'revenue');

        $qb = $this->getEntityManager()->createNativeQuery("SELECT sum(bd.price) AS revenue
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type IN ('SubscriptionChargeSucceed', 'OrderCharged') AND lt.slug IN ('month', 'year')
            AND u.created >= :date_from AND u.created <= :date_to", $rsm);

        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);

        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserRefundsByDate($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('refund', 'refund');

        $qb = $this->getEntityManager()->createNativeQuery("
            SELECT 
              sum(bd.price) as refund
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type = 'OrderRefunded' AND lt.slug IN ('month', 'year')
            AND u.created >= :date_from AND u.created <= :date_to", $rsm);

        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserRefundsCountByDate($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
            SELECT count(bd.user_device_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type = 'OrderRefunded' AND lt.slug IN ('month', 'year')
            AND u.created >= :date_from AND u.created <= :date_to
            GROUP BY bd.user_device_id", $rsm);

        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);

        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserRebillsCountByDate($licenseType, $query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
            SELECT count(bd.user_device_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type = 'SubscriptionChargeSucceed' AND lt.slug = :licence_type
            AND u.created >= :date_from AND u.created <= :date_to
            GROUP BY bd.user_device_id", $rsm);

        $qb->setParameter('licence_type', $licenseType);
        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);

        $users = $qb->getOneOrNullResult();

        return $users;
    }
    public function getUserRebillsByDate($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('rebill', 'rebill');

        $qb = $this->getEntityManager()->createNativeQuery("
            SELECT 
              sum(bd.price) as rebill
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type = 'SubscriptionChargeSucceed' AND lt.slug IN ('month', 'year')
            AND u.created >= :date_from AND u.created <= :date_to", $rsm);

        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserCountByDate($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
           SELECT count(bd.user_device_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type IN ('SubscriptionChargeSucceed', 'OrderCharged') AND lt.slug IN ('month', 'year')
             AND u.created >= :date_from AND u.created <= :date_to
            GROUP BY bd.user_device_id", $rsm);

        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);

        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserDiscountSumByDate($query)
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
           SELECT count(bd.user_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
              LEFT JOIN users u ON u.id = bd.user_id
            WHERE bd.event_type IN ('SubscriptionChargeSucceed', 'OrderCharged') AND lt.slug IN ('month', 'year')
            AND u.created >= :date_from AND u.created <= :date_to
            GROUP BY bd.user_id", $rsm);

        $qb->setParameter('date_from', $query['date-from']);
        $qb->setParameter('date_to', $query['date-to']);

        $users = $qb->getOneOrNullResult();

        return $users;
    }


}