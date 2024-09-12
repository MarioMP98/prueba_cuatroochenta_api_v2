<?php

namespace App\Service;

use App\Collection\SensorCollection;
use App\Decorator\SensorDecorator;
use App\Factory\SensorFactory;
use App\Interface\SensorInterface;
use App\Repository\SensorRepository;
use DateTime;

class SensorService
{
    protected SensorRepository $repository;
    protected SensorFactory $factory;

    public function __construct(
        SensorRepository $repository,
        SensorFactory $factory
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function list($params): array
    {
        $sensors = new SensorCollection($this->repository->list($params));

        return $sensors->getItems();
    }

    public function create($params): array
    {
        $sensor = $this->factory->createSensor();

        $this->assignValues($sensor, $params);
        $this->repository->save($sensor);

        $decorator = new SensorDecorator($sensor);
        return $decorator->parse();
    }

    public function update($id, $params): array|null
    {
        $sensor = $this->repository->find($id);

        if ($sensor) {
            $this->assignValues($sensor, $params);
            $this->repository->save($sensor);
            $decorator = new SensorDecorator($sensor);
            $sensor = $decorator->parse();
        }

        return $sensor;
    }

    public function delete($id, $soft = true): SensorInterface|null
    {
        $sensor = $this->repository->find($id);

        if ($sensor) {

            if ($soft) {
                $sensor->setDeletedAt(new DateTime());
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
            $sensor->setCreatedAt(new DateTime());
        }

        $sensor->setUpdatedAt(new DateTime());
    }
}
