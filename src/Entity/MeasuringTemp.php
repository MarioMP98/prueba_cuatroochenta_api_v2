<?php

namespace App\Entity;

use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class MeasuringTemp extends Measuring implements MeasuringInterface
{
    #[ORM\Column(nullable: true)]
    private ?float $temperature = null;

    public function getValue(): ?float
    {
        return $this->temperature;
    }

    public function setValue($value): static
    {
        $this->temperature = $value;

        return $this;
    }

    public function parse(): array
    {
        return array(
            'id' => $this->getId(),
            'year' => $this->getYear(),
            'type' => "Temperature",
            'value' => $this->temperature ?
                number_format($this->temperature, 2, ',', '.') . ' ºC' :
                null,
            'created_at' => $this->formatDateTime($this->createdAt),
            'updated_at' => $this->formatDateTime($this->updatedAt),
            'deleted_at' => $this->formatDateTime($this->deletedAt)
        );
    }
}
