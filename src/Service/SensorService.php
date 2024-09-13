<?php

namespace App\Service;

use App\Assembler\SensorAssembler;
use App\Collection\SensorCollection;
use App\Decorator\SensorDecorator;
use App\Factory\SensorFactory;
use App\Interface\SensorInterface;
use App\Repository\SensorRepository;
use App\Traits\CollectionParser;
use DateTime;

class SensorService
{
    use CollectionParser;

    protected SensorRepository $repository;
    protected SensorFactory $factory;
    protected SensorAssembler $assembler;

    public function __construct(
        SensorRepository $repository,
        SensorFactory $factory,
        SensorAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->assembler = $assembler;
    }

    public function list($params): array
    {
        $sensors = new SensorCollection($this->repository->list($params));

        return $this->parseCollection($sensors);
    }

    public function create($params): array
    {
        $sensor = $this->factory->createSensor();

        $this->assembler->assignValues($sensor, $params);
        $this->repository->create($sensor);

        $decorator = new SensorDecorator($sensor);
        return $decorator->parse();
    }

    public function update($id, $params): array|null
    {
        $sensor = $this->repository->find($id);

        if ($sensor) {
            $this->assembler->assignValues($sensor, $params);
            $this->repository->save();

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
                $this->repository->save();
            } else {
                $this->repository->delete($sensor);
            }
        }

        return $sensor;
    }
}
