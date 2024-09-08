<?php

namespace App\Repository;

use App\Entity\Measuring;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measuring>
 */
class MeasuringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measuring::class);
    }

    public function list(): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT m FROM App\Entity\Measuring m';

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
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
