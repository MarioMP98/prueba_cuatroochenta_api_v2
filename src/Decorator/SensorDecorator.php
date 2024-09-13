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
        // Implementado para evitar exceptions
    }

    public function getName()
    {
        // Implementado para evitar exceptions
    }

    public function setName(?string $name)
    {
        // Implementado para evitar exceptions
    }
}
