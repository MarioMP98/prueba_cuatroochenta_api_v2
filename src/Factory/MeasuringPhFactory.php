<?php

namespace App\Factory;

use App\Entity\MeasuringPh;
use App\Interface\MeasuringAbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringPhFactory implements MeasuringAbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringPh();
    }
}