<?php

namespace App\Factory;

use App\Entity\MeasuringPh;
use App\Interface\AbstractFactory;
use App\Interface\MeasuringInterface;

class MeasuringPhFactory implements AbstractFactory
{
    public function createMeasuring(): MeasuringInterface
    {
        return new MeasuringPh();
    }
}