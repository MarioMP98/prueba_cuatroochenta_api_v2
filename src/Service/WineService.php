<?php

namespace App\Service;

use App\Assembler\WineAssembler;
use App\Collection\WineCollection;
use App\Decorator\WineWithMeasuringsDecorator;
use App\Factory\WineFactory;
use App\Interface\WineInterface;
use App\Repository\WineRepository;
use App\Traits\CollectionParser;
use DateTime;

class WineService
{
    use CollectionParser;

    protected WineRepository $repository;
    protected WineFactory $factory;
    protected WineAssembler $assembler;

    public function __construct(
        WineRepository $repository,
        WineFactory $factory,
        WineAssembler $allocator
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->assembler = $allocator;
    }

    public function list($params): array
    {
        $wines = new WineCollection($this->repository->list($params));

        return $this->parseCollection($wines);
    }

    public function create($params): array
    {
        $wine = $this->factory->createWine();

        $this->assembler->assignValues($wine, $params);
        $this->repository->create($wine);

        $decorator = new WineWithMeasuringsDecorator($wine);

        return $decorator->parse();
    }

    public function update($id, $params): array|null
    {
        $wine = $this->repository->find($id);

        if ($wine) {
            $this->assembler->assignValues($wine, $params);
            $this->repository->save();

            $decorator = new WineWithMeasuringsDecorator($wine);
            $wine = $decorator->parse();
        }

        return $wine;
    }

    public function delete($id, $soft = true): WineInterface|null
    {
        $wine = $this->repository->find($id);

        if ($wine) {

            if ($soft) {
                $wine->setDeletedAt(new DateTime());
                $this->repository->save();
            } else {
                $this->repository->delete($wine);
            }
        }

        return $wine;
    }
}
