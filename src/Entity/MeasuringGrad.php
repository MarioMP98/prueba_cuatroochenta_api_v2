<?php

namespace App\Entity;

use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class MeasuringGrad extends Measuring implements MeasuringInterface
{
    #[ORM\Column(nullable: true)]
    private ?float $graduation = null;

    public function getValue(): ?float
    {
        return $this->graduation;
    }

    public function setValue($value): static
    {
        $this->graduation = $value;

        return $this;
    }

    public function parse(): array
    {
        return array(
            'id' => $this->getId(),
            'year' => $this->getYear(),
            'type' => "Graduation",
            'value' => $this->graduation ?
                number_format($this->graduation, 2, ',', '.')
                . 'cc' :
                null,
            'created_at' => $this->formatDateTime($this->createdAt),
            'updated_at' => $this->formatDateTime($this->updatedAt),
            'deleted_at' => $this->formatDateTime($this->deletedAt)
        );
    }
}
