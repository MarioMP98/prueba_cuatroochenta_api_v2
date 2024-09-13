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
    protected $entityManager;

    public function __construct(ManagerRegistry $registry, MeasuringQueryBuilder $builder)
    {
        parent::__construct($registry, Measuring::class);
        $this->entityManager = $this->getEntityManager();
        $this->builder = $builder;
    }

    public function list($params): array
    {
        $query = $this->builder->buildQuery($this->entityManager, $params);

        return $query->execute();
    }

    public function create($measuring): void
    {
        $this->entityManager->persist($measuring);
        $this->save();
    }

    public function delete($measuring): void
    {
        $this->entityManager->remove($measuring);
        $this->save();
    }

    public function save(): void
    {
        $this->entityManager->flush();
    }
}
