<?php

namespace App\Decorator;

use App\Entity\Measuring;
use App\Interface\MeasuringInterface;
use DateTime;

class MeasuringDecorator implements MeasuringInterface
{
    protected Measuring $measuring;

    public function __construct(Measuring $measuring)
    {
        $this->measuring = $measuring;
    }

    public function parse(): array
    {
        return $this->measuring->parse();
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

    public function setCreatedAt(DateTime $createdAt)
    {
        // Implementado para evitar exceptions
    }

    public function setUpdatedAt(DateTime $updatedAt)
    {
        // Implementado para evitar exceptions
    }

    public function setDeletedAt(?DateTime $deletedAt = null)
    {
        // Implementado para evitar exceptions
    }

    public function getValue()
    {
        // Implementado para evitar exceptions
    }

    public function setValue($value): static
    {
        // Implementado para evitar exceptions
    }
}
