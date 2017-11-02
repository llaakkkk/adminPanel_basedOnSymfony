<?php
/**
 * Created by PhpStorm.
 * User: lakie
 * Date: 02.11.2017
 * Time: 16:20
 */

namespace UserBundle\Repository;

use \Doctrine\ORM\EntityRepository;


class LicenseTypesRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

}