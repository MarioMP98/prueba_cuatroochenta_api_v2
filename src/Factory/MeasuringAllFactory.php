<?php

namespace App\Factory;

use App\Entity\MeasuringAll;
use App\Interface\MeasuringAbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringAllFactory implements MeasuringAbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringAll();
    }
}
