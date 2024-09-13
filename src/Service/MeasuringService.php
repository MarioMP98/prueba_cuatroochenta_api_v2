<?php

namespace App\Service;

use App\Assembler\MeasuringAssembler;
use App\Collection\MeasuringCollection;
use App\Decorator\MeasuringWithRelationshipDecorator;
use App\Factory\MeasuringAllFactory;
use App\Factory\MeasuringFactorySwitch;
use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use App\Traits\CollectionParser;
use DateTime;

class MeasuringService
{
    use CollectionParser;

    protected MeasuringRepository $repository;
    protected MeasuringAssembler $assembler;

    public function __construct(
        MeasuringRepository $repository,
        MeasuringAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    public function list($params): array
    {
        $measurings = new MeasuringCollection($this->repository->list($params));

        return $this->parseCollection($measurings);
    }

    public function create($params): array
    {
        $switch = new MeasuringFactorySwitch();
        $factory = isset($params['type']) ?
            $switch->selectFactory($params['type']) :
            new MeasuringAllFactory();

        $measuring = $factory->createMeasuring();

        $this->assembler->assignValues($measuring, $params);
        $this->assembler->handleRelationships($measuring, $params);
        $this->repository->create($measuring);

        $decorator = new MeasuringWithRelationshipDecorator($measuring);
        return $decorator->parse();
    }

    public function update($id, $params): array|null
    {
        $measuring = $this->repository->find($id);

        if ($measuring) {
            $this->assembler->updateValues($measuring, $params);
            $this->assembler->handleRelationships($measuring, $params);
            $this->repository->save();

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
                $this->repository->save();
            } else {
                $this->repository->delete($measuring);
            }
        }

        return $measuring;
    }
}
