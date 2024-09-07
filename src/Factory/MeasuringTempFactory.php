<?php

namespace App\Factory;

use App\Entity\MeasuringTemp;
use App\Interface\MeasuringAbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringTempFactory implements MeasuringAbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringTemp();
    }
}