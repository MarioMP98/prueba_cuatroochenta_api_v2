<?php

namespace App\Service;

use App\Collection\MeasuringCollection;
use App\Decorator\MeasuringWithRelationshipDecorator;
use App\Factory\MeasuringAllFactory;
use App\Factory\MeasuringColorFactory;
use App\Factory\MeasuringGradFactory;
use App\Factory\MeasuringPhFactory;
use App\Factory\MeasuringTempFactory;
use App\Interface\MeasuringAbstractFactory;
use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use DateTime;

class MeasuringService
{
    protected MeasuringRepository $repository;
    protected SensorRepository $sensorRepository;
    protected WineRepository $wineRepository;

    public function __construct(
        MeasuringRepository $repository,
        SensorRepository $sensorRepository,
        WineRepository $wineRepository
    ) {
        $this->repository = $repository;
        $this->sensorRepository = $sensorRepository;
        $this->wineRepository = $wineRepository;
    }

    public function list($params): array
    {
        $measurings = new MeasuringCollection($this->repository->list($params));

        return $measurings->getItems();
    }

    public function create($params): array
    {
        $factory = isset($params['type']) ?
            $this->selectFactory($params['type']) :
            new MeasuringAllFactory();

        $measuring = $factory->createMeasuring();

        $this->assignValues($measuring, $params);
        $this->handleRelationships($measuring, $params);
        $this->repository->save($measuring);

        $decorator = new MeasuringWithRelationshipDecorator($measuring);
        return $decorator->parse();
    }

    public function update($id, $params): array|null
    {
        $measuring = $this->repository->find($id);

        if ($measuring) {
            $this->updateValues($measuring, $params);
            $this->handleRelationships($measuring, $params);
            $this->repository->save($measuring);

            $decorator = new MeasuringWithRelationshipDecorator($measuring);
            $measuring = $decorator->parse();
        }

        return $measuring;
    }

    public function delete($id, $soft = true): MeasuringInterface|null
    {
        $measuring = $this->repository->find($id);

        if ($measuring) {

            if ($soft) {
                $measuring->setDeletedAt(new DateTime());
                $this->repository->save($measuring);
            } else {
                $this->repository->delete($measuring);
            }
        }

        return $measuring;
    }

    private function selectFactory($value): MeasuringAbstractFactory|null
    {
        return match ($value) {
            "color" => new MeasuringColorFactory(),
            "temp" => new MeasuringTempFactory(),
            "graduation" => new MeasuringGradFactory(),
            "ph" => new MeasuringPhFactory(),
            default => new MeasuringAllFactory(),
        };
    }

    private function assignValues($measuring, $params): void
    {
        if (isset($params['year'])) {
            $measuring->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['type'])) {
            if (isset($params['value'])) {
                $measuring->setValue($params['value']);
            }
        } else {
            $this->setAllValues($measuring, $params);
        }

        $measuring->setCreatedAt(new DateTime());
        $measuring->setUpdatedAt(new DateTime());
    }

    private function updateValues($measuring, $params): void
    {
        if (isset($params['year'])) {
            $measuring->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['value'])) {
            $measuring->setValue($params['value']);
        } else {
            $this->setAllValues($measuring, $params);
        }

        $measuring->setUpdatedAt(new DateTime());
    }

    private function setAllValues($measuring, $params): void
    {
        if (isset($params['color'])) {
            $measuring->setColor($params['color']);
        }

        if (isset($params['temperature'])) {
            $measuring->setTemperature(doubleval($params['temperature']) ?: null);
        }

        if (isset($params['graduation'])) {
            $measuring->setGraduation(doubleval($params['graduation']) ?: null);
        }

        if (isset($params['ph'])) {
            $measuring->setPh(doubleval($params['ph']) ?: null);
        }
    }

    private function handleRelationships($measuring, $params)
    {
        [$sensor, $wine] = $this->getRelatedEntities($params);

        if ($sensor) {
            $measuring->setSensor($sensor);
        }

        if ($wine) {
            $measuring->setWine($wine);
        }
    }

    private function getRelatedEntities($params): array
    {
        $sensor = null;
        $wine = null;

        if (isset($params['sensor'])) {
            $sensor = $this->sensorRepository->find($params['sensor']);
        }

        if (isset($params['wine'])) {
            $wine = $this->wineRepository->find($params['wine']);
        }

        return [$sensor, $wine];
    }
}
