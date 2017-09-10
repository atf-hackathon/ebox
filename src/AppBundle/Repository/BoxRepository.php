<?php

namespace AppBundle\Repository;

/**
 * BoxRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BoxRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll() {
        $qb = $this->createQueryBuilder('b')
            ->select([
                'por.id as product_order_id',
                'por.orderId',
                'b.id',
                'b.availability',
                'b.availabilityDate'
            ])
            ->leftJoin('b.productOrder', 'por');

        return $qb->getQuery()->getResult();
    }
}
