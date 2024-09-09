<?php

namespace App\Interface;

interface SensorInterface
{
    public function getId();

    public function getName();

    public function setName(?string $name);

    public function parse(): array;
}
