<?php

namespace App\Factory;

use App\Entity\MeasuringGrad;
use App\Interface\MeasuringAbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringGradFactory implements MeasuringAbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringGrad();
    }
}