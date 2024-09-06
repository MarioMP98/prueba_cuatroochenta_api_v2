<?php

namespace App\Factory;

use App\Entity\MeasuringGrad;
use App\Interface\AbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringGradFactory implements AbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringGrad();
    }
}