<?php

namespace App\Factory;

use App\Entity\MeasuringTemp;
use App\Interface\AbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringTempFactory implements AbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringTemp();
    }
}