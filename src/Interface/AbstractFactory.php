<?php

namespace App\Interface;


interface AbstractFactory
{
    public function createMeasuring(): MeasuringInterface;
}