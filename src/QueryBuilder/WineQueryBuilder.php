<?php

namespace App\QueryBuilder;

use Doctrine\ORM\Query;

class WineQueryBuilder
{
    public function buildQuery($entityManager, $params): Query
    {
        $query = $entityManager->createQueryBuilder();
        $query->select('w');
        $query->from('App\Entity\Wine', 'w');

        if (!isset($params['getDeleted']) || !$params['getDeleted']) {
            $query->where('w.deletedAt IS NULL');
        }

        if (isset($params['year'])) {
            $query->andWhere('w.year = :year')->setParameter('year', $params['year']);
        }

        return $query->getQuery();
    }
}
