<?php

namespace App\Entity;

use App\Interface\MeasuringInterface;
use App\Repository\MeasuringAllRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringAllRepository::class)]
class MeasuringAll extends Measuring implements MeasuringInterface
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(nullable: true)]
    private ?float $temperature = null;

    #[ORM\Column(nullable: true)]
    private ?float $graduation = null;

    #[ORM\Column(nullable: true)]
    private ?float $ph = null;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor($color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature($temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getGraduation(): ?float
    {
        return $this->graduation;
    }

    public function setGraduation($graduation): static
    {
        $this->graduation = $graduation;

        return $this;
    }

    public function getPh(): ?float
    {
        return $this->ph;
    }

    public function setPh($ph): static
    {
        $this->ph = $ph;

        return $this;
    }

    public function parse(): array
    {
        return [
            'id' => $this->getId(),
            'year' => $this->getYear(),
            'type' => 'All',
            'color' => $this->color,
            'temperature' => $this->temperature,
            'graduation' => $this->graduation,
            'ph' => $this->ph,
            'created_at' => $this->formatDateTime($this->createdAt),
            'updated_at' => $this->formatDateTime($this->updatedAt),
            'deleted_at' => $this->formatDateTime($this->deletedAt),
        ];
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
