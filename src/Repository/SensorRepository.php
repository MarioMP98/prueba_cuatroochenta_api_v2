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
    protected $entityManager;

    public function __construct(ManagerRegistry $registry, SensorQueryBuilder $builder)
    {
        parent::__construct($registry, Sensor::class);
        $this->entityManager = $this->getEntityManager();
        $this->builder = $builder;
    }

    public function list($params): array
    {
        $query = $this->builder->buildQuery($this->entityManager, $params);

        return $query->execute();
    }

    public function create($sensor): void
    {
        $this->entityManager->persist($sensor);
        $this->save();
    }

    public function delete($sensor): void
    {
        $this->entityManager->remove($sensor);
        $this->save();
    }

    public function save(): void
    {
        $this->entityManager->flush();
    }
}
