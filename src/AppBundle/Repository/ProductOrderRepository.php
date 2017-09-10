<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;

/**
 * ProductOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductOrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll($filters = []) {
        $qb = $this->createQueryBuilder('por')
            ->select([
                'por.id',
                'por.orderId',
                'por.orderStatus',
                'p.id as product_id',
                'p.name',
                'b.id as box_id'
            ])
            ->leftJoin('por.product', 'p')
            ->leftJoin('por.box', 'b')
            ->where('1 = 1');

        if (isset($filters['search'])) {
            $qb->andWhere('por.orderId LIKE :orderId')
                ->setParameter('orderId', '%' . $filters['search']['value'] . '%');
        }

        if (isset($filters['filterStatus'])) {
            switch ($filters['filterStatus']) {
                case 1: $qb->andWhere('por.orderStatus = 0');
                    break;
                case 2: $qb->andWhere('por.orderStatus = 1');

                    break;
                case 3: $qb->andWhere('b.availabilityDate < :twoDaysInterval')
                    ->setParameter('twoDaysInterval', 'NOW() - INTERVAL 2 DAY');
                    break;
                default:
                    break;
            }
        }

        return $qb->getQuery()->getResult();
    }
}
