<?php

namespace App\Decorator;

use App\Entity\Wine;
use App\Interface\WineInterface;

class WineDecorator implements WineInterface
{
    protected Wine $wine;

    public function __construct(Wine $wine)
    {
        $this->wine = $wine;
    }

    public function parse(): array
    {
        return $this->wine->parse();
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

    public function getYear()
    {
        // Implementado para evitar exceptions
    }

    public function setYear(?int $year)
    {
        // Implementado para evitar exceptions
    }
}
