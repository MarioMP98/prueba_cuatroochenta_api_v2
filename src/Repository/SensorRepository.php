<?php

namespace App\Repository;

use App\Entity\Sensor;
use App\QueryBuilder\SensorQueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sensor>
 */
class SensorRepository extends ServiceEntityRepository
{
    protected SensorQueryBuilder $builder;

    public function __construct(ManagerRegistry $registry, SensorQueryBuilder $builder)
    {
        parent::__construct($registry, Sensor::class);
        $this->builder = $builder;
    }

    public function list($params): array
    {
        $entityManager = $this->getEntityManager();
        $query = $this->builder->buildQuery($entityManager, $params);

        return $query->execute();
    }

    public function save($sensor): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($sensor);
        $entityManager->flush();
    }

    public function delete($sensor): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($sensor);
        $entityManager->flush();
    }
}
