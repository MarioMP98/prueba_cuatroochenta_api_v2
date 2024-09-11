<?php

namespace App\QueryBuilder;

use Doctrine\ORM\Query;

class SensorQueryBuilder
{
    public function buildQuery($entityManager, $params): Query
    {
        $query = $entityManager->createQueryBuilder();
        $query->select('s');
        $query->from('App\Entity\Sensor', 's');

        if (!isset($params['getDeleted']) || !$params['getDeleted']) {
            $query->where('s.deletedAt IS NULL');
        }

        return $query->getQuery();
    }
}
