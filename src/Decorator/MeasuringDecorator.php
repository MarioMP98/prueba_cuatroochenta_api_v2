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

    public function getYear()
    {
        // TODO: Implement getYear() method.
    }

    public function setYear(?int $year)
    {
        // TODO: Implement setYear() method.
    }

    public function setCreatedAt(DateTime $createdAt)
    {
        // TODO: Implement setCreatedAt() method.
    }

    public function setUpdatedAt(DateTime $updatedAt)
    {
        // TODO: Implement setUpdatedAt() method.
    }

    public function setDeletedAt(?DateTime $deletedAt = null)
    {
        // TODO: Implement setDeletedAt() method.
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }

    public function setValue($value): static
    {
        // TODO: Implement setValue() method.
    }
}
