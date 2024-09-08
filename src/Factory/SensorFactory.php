<?php

namespace App\Factory;

use App\Entity\Sensor;
use App\Interface\SensorAbstractFactory;
use App\Interface\SensorInterface;

class SensorFactory implements SensorAbstractFactory
{
    public function createSensor(): SensorInterface
    {
        return new Sensor();
    }
}
