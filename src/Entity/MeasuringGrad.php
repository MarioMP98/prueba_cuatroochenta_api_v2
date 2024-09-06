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
}
