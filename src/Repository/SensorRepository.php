<?php

namespace App\Repository;

use App\Entity\Sensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sensor>
 */
class SensorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sensor::class);
    }

    public function list(): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT s FROM App\Entity\Sensor s';

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
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
