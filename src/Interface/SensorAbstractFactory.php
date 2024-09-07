<?php

namespace App\Interface;


interface SensorAbstractFactory
{
    public function createSensor(): SensorInterface;
}