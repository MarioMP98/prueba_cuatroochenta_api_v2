<?php

namespace App\Service;

use App\Decorator\WineWithMeasuringsDecorator;
use App\Factory\WineFactory;
use App\Interface\WineInterface;
use App\Repository\WineRepository;
use DateTime;

class WineService
{
    protected WineRepository $repository;
    protected WineFactory $factory;

    public function __construct(
        WineRepository $repository,
        WineFactory $factory
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function list(): array
    {
        $wines = $this->repository->list();

        return $this->parseWines($wines);
    }

    public function create($params): WineInterface
    {
        $wine = $this->factory->createWine();
        
        $this->assignValues($wine, $params);
        $this->repository->save($wine);

        return $wine;
    }

    public function update($id, $params): WineInterface|null
    {
        $wine = $this->repository->find($id);

        if ($wine) {
            $this->assignValues($wine, $params);
            $this->repository->save($wine);
        }

        return $wine;
    }

    public function delete($id, $soft = true): WineInterface|null
    {
        $wine = $this->repository->find($id);

        if ($wine) {

            if ($soft) {
                $wine->setDeletedAt(new DateTime());
                $this->repository->save($wine);
            } else {
                $this->repository->delete($wine);
            }
        }

        return $wine;
    }

    private function assignValues($wine, $params): void
    {
        if (isset($params['year'])) {
            $wine->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['name'])) {
            $wine->setName($params['name']);
        }
        
        if (is_null($wine->getId())) {
            $wine->setCreatedAt(new DateTime());
        }
         
        $wine->setUpdatedAt(new DateTime());
    }

    private function parseWines($wines): array
    {
        $array = array();

        foreach ($wines as $wine) {
            $decorator = new WineWithMeasuringsDecorator($wine);
            $array[] = $decorator->parse();
        }

        return $array;
    }
}
