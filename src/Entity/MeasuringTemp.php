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
}
