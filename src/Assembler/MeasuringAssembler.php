<?php

namespace App\Assembler;

use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use DateTime;

class MeasuringAssembler
{
    protected SensorRepository $sensorRepository;
    protected WineRepository $wineRepository;

    public function __construct(
        SensorRepository $sensorRepository,
        WineRepository $wineRepository
    ) {
        $this->sensorRepository = $sensorRepository;
        $this->wineRepository = $wineRepository;
    }

    public function assignValues($measuring, $params): void
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

    public function updateValues($measuring, $params): void
    {
        if (isset($params['year'])) {
            $measuring->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['value']) && isset($measuring->value)) {
            $measuring->setValue($params['value']);
        } else {
            $this->setAllValues($measuring, $params);
        }

        $measuring->setUpdatedAt(new DateTime());
    }

    public function setAllValues($measuring, $params): void
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

    public function handleRelationships($measuring, $params)
    {
        [$sensor, $wine] = $this->getRelatedEntities($params);

        if ($sensor) {
            $measuring->setSensor($sensor);
        }

        if ($wine) {
            $measuring->setWine($wine);
        }
    }

    public function getRelatedEntities($params): array
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
