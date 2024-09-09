<?php

namespace App\Entity;

use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class MeasuringColor extends Measuring implements MeasuringInterface
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    public function getValue(): ?string
    {
        return $this->color;
    }

    public function setValue($value): static
    {
        $this->color = $value;

        return $this;
    }

    public function parse(): array
    {
        return array(
            'id' => $this->getId(),
            'year' => $this->getYear(),
            'type' => "Color",
            'value' => $this->color,
            'created_at' => $this->formatDateTime($this->createdAt),
            'updated_at' => $this->formatDateTime($this->updatedAt),
            'deleted_at' => $this->formatDateTime($this->deletedAt)
        );
    }
}
