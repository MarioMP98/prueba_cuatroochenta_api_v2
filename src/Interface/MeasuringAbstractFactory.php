<?php

namespace App\Interface;


interface MeasuringAbstractFactory
{
    public function createMeasuring(): MeasuringInterface;
}
