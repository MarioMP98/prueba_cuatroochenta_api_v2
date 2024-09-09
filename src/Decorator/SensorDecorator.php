<?php

namespace App\Decorator;

use App\Entity\Sensor;
use App\Interface\SensorInterface;

class SensorDecorator implements SensorInterface
{
    protected Sensor $sensor;

    public function __construct(Sensor $sensor)
    {
        $this->sensor = $sensor;
    }

    public function parse(): array
    {
        return $this->sensor->parse();
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function setName(?string $name)
    {
        // TODO: Implement setName() method.
    }
}
