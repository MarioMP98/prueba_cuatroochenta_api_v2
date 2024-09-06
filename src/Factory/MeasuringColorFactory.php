<?php

namespace App\Factory;

use App\Entity\MeasuringColor;
use App\Interface\AbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringColorFactory implements AbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringColor();
    }
}