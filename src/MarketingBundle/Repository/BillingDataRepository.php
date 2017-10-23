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
    public function getUserRevenueByDate()
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('revenue', 'revenue');

        $qb = $this->getEntityManager()->createNativeQuery("SELECT sum(bd.price) AS revenue
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
            WHERE bd.event_type IN ('SubscriptionChargeSucceed', 'OrderCharged') AND lt.slug IN ('month', 'year')", $rsm);

//        $qb->setParameter(1, $licenseType);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserRefundsByDate()
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('refund', 'refund');

        $qb = $this->getEntityManager()->createNativeQuery("
            SELECT 
              sum(bd.price) as refund
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
            WHERE bd.event_type = 'OrderRefunded' AND lt.slug IN ('month', 'year');", $rsm);

//        $qb->setParameter(1, $licenseType);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserRefundsCountByDate()
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
            SELECT count(bd.user_device_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
            WHERE bd.event_type = 'OrderRefunded' AND lt.slug IN ('month', 'year')
            GROUP BY bd.user_device_id", $rsm);

//        $qb->setParameter(1, $licenseType);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserCountByDate()
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
           SELECT count(bd.user_device_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
            WHERE bd.event_type IN ('SubscriptionChargeSucceed', 'OrderCharged') AND lt.slug IN ('month', 'year')
            GROUP BY bd.user_device_id", $rsm);

//        $qb->setParameter(1, $licenseType);
        $users = $qb->getOneOrNullResult();

        return $users;
    }

    public function getUserDiscountSumByDate()
    {
        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('user_count', 'user_count');

        $qb = $this->getEntityManager()->createNativeQuery("
           SELECT count(bd.user_id) AS user_count
            FROM billing_data bd
              INNER JOIN payment_system_products psp ON psp.id = bd.product_id
              INNER JOIN license_types lt ON lt.id = psp.license_type_id
            WHERE bd.event_type IN ('SubscriptionChargeSucceed', 'OrderCharged') AND lt.slug IN ('month', 'year')
            GROUP BY bd.user_id", $rsm);

//        $qb->setParameter(1, $licenseType);
        $users = $qb->getOneOrNullResult();

        return $users;
    }


}