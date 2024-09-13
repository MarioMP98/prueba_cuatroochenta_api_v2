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
    protected $entityManager;

    public function __construct(ManagerRegistry $registry, WineQueryBuilder $builder)
    {
        parent::__construct($registry, Wine::class);
        $this->entityManager = $this->getEntityManager();
        $this->builder = $builder;
    }

    public function list($params): array
    {
        $query = $this->builder->buildQuery($this->entityManager, $params);

        return $query->execute();
    }

    public function create($wine): void
    {
        $this->entityManager->persist($wine);
        $this->save();
    }

    public function delete($wine): void
    {
        $this->entityManager->remove($wine);
        $this->save();
    }

    public function save(): void
    {
        $this->entityManager->flush();
    }
}
