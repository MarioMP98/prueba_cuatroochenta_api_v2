<?php

namespace App\Service;

use App\Entity\Measuring;
use App\Factory\MeasuringColorFactory;
use App\Factory\MeasuringGradFactory;
use App\Factory\MeasuringPhFactory;
use App\Factory\MeasuringTempFactory;
use App\Interface\AbstractFactory;
use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use App\Traits\Parser;

class MeasuringService
{
    use Parser;

    protected $repository;
    protected $sensorRepository;
    protected $wineRepository;


    public function __construct(
        MeasuringRepository $repository,
        SensorRepository $sensorRepository,
        WineRepository $wineRepository
    ) {
        $this->repository = $repository;
        $this->sensorRepository = $sensorRepository;
        $this->wineRepository = $wineRepository;
    }


    public function list(): array
    {
        $measurings = $this->repository->list();

        return $this->parseMeasurings($measurings);
    }


    public function create($params): MeasuringInterface
    {
        $factory = $this->selectFactory($params['type']);

        $measuring = $factory->createMeasuring();
        
        $this->assignValues($measuring, $params);
        $this->repository->save($measuring);

        return $measuring;
    }


    public function update($id, $params): Measuring|null
    {
        $measuring = $this->repository->find($id);

        if ($measuring) {
            $this->updateValues($measuring, $params);
            $this->repository->save($measuring);
        }

        return $measuring;
    }


    public function delete($id, $soft = true): Measuring|null
    {
        $measuring = $this->repository->find($id);

        if ($measuring) {

            if($soft) {
                $measuring->setDeletedAt(new \DateTime());
                $this->repository->save($measuring);
            } else {
                $this->repository->delete($measuring);
            } 
        }
        return $measuring;
    }

    private function getSensorAndWine($params): array
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

    private function selectFactory($value): AbstractFactory
    {
        switch ($value) {
            case "color":
                $factory = new MeasuringColorFactory();
                break;
            case "temp":
                $factory = new MeasuringTempFactory();
                break;
            case "graduation":
                $factory = new MeasuringGradFactory();
                break;
            case "ph":
                $factory = new MeasuringPhFactory();
                break;
            default:
                $factory = null;
                break;
        }

        return $factory;
    }

    private function assignValues($measuring, $params): void
    {
        if(isset($params['year'])) {
            $measuring->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['type']) && isset($params['value'])) {
            $measuring->setValue($params['value']);
        }
        
        $measuring->setCreatedAt(new \DateTime());   
        $measuring->setUpdatedAt(new \DateTime());
    }

    private function updateValues($measuring, $params): void
    {
        if(isset($params['year'])) {
            $measuring->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['value'])) {
            $measuring->setValue($params['value']);
        }
        
        $measuring->setUpdatedAt(new \DateTime());
    }
}
