<?php

namespace App\QueryBuilder;

use Doctrine\ORM\Query;

class MeasuringQueryBuilder
{
    public function buildQuery($entityManager, $params): Query
    {
        $query = $entityManager->createQueryBuilder();
        $query->select('m');

        if (isset($params['type'])) {
            $query->from('App\Entity\Measuring' . $params['type'], 'm');
        } else {
            $query->from('App\Entity\Measuring', 'm');
        }

        if (!isset($params['getDeleted']) || !$params['getDeleted']) {
            $query->where('m.deletedAt IS NULL');
        }

        if (isset($params['year'])) {
            $query->andWhere('m.year = :year')->setParameter('year', $params['year']);
        }

        $query->orderBy('m.id');

        return $query->getQuery();
    }
}
