<?php

namespace App\Entity;

use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class MeasuringGrad extends Measuring
{
    #[ORM\Column(nullable: true)]
    private ?float $graduation = null;

    public function getGraduation(): ?float
    {
        return $this->graduation;
    }

    public function setGraduation(?float $graduation): static
    {
        $this->graduation = $graduation;

        return $this;
    }
}
