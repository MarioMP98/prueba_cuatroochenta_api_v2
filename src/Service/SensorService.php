<?php

namespace App\Service;

use App\Factory\SensorFactory;
use App\Interface\SensorInterface;
use App\Repository\SensorRepository;
use App\Traits\Parser;

class SensorService
{
    use Parser;

    protected $repository;
    protected $factory;

    public function __construct(
        SensorRepository $repository,
        SensorFactory $factory
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function list(): array
    {
        $sensors = $this->repository->list();

        return $this->parseSensors($sensors);
    }

    public function create($params): SensorInterface
    {
        $sensor = $this->factory->createSensor();
        
        $this->assignValues($sensor, $params);
        $this->repository->save($sensor);

        return $sensor;
    }

    public function update($id, $params): SensorInterface|null
    {
        $sensor = $this->repository->find($id);

        if ($sensor) {
            $this->assignValues($sensor, $params);
            $this->repository->save($sensor);
        }

        return $sensor;
    }


    public function delete($id, $soft = true): SensorInterface|null
    {
        $sensor = $this->repository->find($id);

        if ($sensor) {

            if($soft) {
                $sensor->setDeletedAt(new \DateTime());
                $this->repository->save($sensor);
            } else {
                $this->repository->delete($sensor);
            } 
        }

        return $sensor;
    }

    private function assignValues($sensor, $params): void
    {
        if (isset($params['name'])) {
            $sensor->setName($params['name']);
        }
        
        if (is_null($sensor->getId())) {
            $sensor->setCreatedAt(new \DateTime());  
        }
         
        $sensor->setUpdatedAt(new \DateTime());
    }

}
