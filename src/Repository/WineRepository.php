<?php

namespace App\Repository;

use App\Entity\Wine;
use App\QueryBuilder\WineQueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wine>
 */
class WineRepository extends ServiceEntityRepository
{
    protected WineQueryBuilder $builder;

    public function __construct(ManagerRegistry $registry, WineQueryBuilder $builder)
    {
        parent::__construct($registry, Wine::class);
        $this->builder = $builder;
    }

    public function list($params): array
    {
        $entityManager = $this->getEntityManager();
        $query = $this->builder->buildQuery($entityManager, $params);

        return $query->execute();
    }

    public function save($wine): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($wine);
        $entityManager->flush();
    }

    public function delete($wine): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($wine);
        $entityManager->flush();
    }
}
