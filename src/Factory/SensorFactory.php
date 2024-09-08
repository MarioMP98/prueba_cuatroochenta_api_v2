<?php

namespace App\Factory;

use App\Entity\Sensor;
use App\Interface\SensorInterface;

class SensorFactory
{
    public function createSensor(): SensorInterface
    {
        return new Sensor();
    }
}
