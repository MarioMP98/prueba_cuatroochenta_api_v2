<?php

namespace App\Repository;

use App\Entity\Measuring;
use App\QueryBuilder\MeasuringQueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measuring>
 */
class MeasuringRepository extends ServiceEntityRepository
{
    protected MeasuringQueryBuilder $builder;

    public function __construct(ManagerRegistry $registry, MeasuringQueryBuilder $builder)
    {
        parent::__construct($registry, Measuring::class);
        $this->builder = $builder;
    }

    public function list($params): array
    {
        $entityManager = $this->getEntityManager();
        $query = $this->builder->buildQuery($entityManager, $params);

        return $query->execute();
    }

    public function save($measuring): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($measuring);
        $entityManager->flush();
    }

    public function delete($measuring): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($measuring);
        $entityManager->flush();
    }
}
