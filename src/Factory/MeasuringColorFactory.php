<?php

namespace App\Factory;

use App\Entity\MeasuringColor;
use App\Interface\MeasuringAbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringColorFactory implements MeasuringAbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringColor();
    }
}
