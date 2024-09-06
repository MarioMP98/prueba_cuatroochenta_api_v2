<?php

namespace App\Entity;

use App\Interface\MeasuringInterface;
use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class MeasuringPh extends Measuring implements MeasuringInterface
{
    #[ORM\Column(nullable: true)]
    private ?float $ph = null;

    public function getValue(): ?float
    {
        return $this->ph;
    }

    public function setValue($value): static
    {
        $this->ph = $value;

        return $this;
    }
}
