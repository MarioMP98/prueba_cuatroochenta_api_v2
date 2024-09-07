<?php

namespace App\Repository;

use App\Entity\Wine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wine>
 */
class WineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wine::class);
    }

    public function list(): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT w FROM App\Entity\Wine w';

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
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
