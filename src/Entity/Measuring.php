<?php

namespace App\Entity;

use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(
    [
        'color' => MeasuringColor::class,
        'temperature' => MeasuringTemp::class,
        'graduation' => MeasuringGrad::class,
        'ph' => MeasuringPh::class,
    ]
)]
class Measuring
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    #[ORM\ManyToOne(inversedBy: 'measurings')]
    private ?Sensor $Sensor = null;

    #[ORM\ManyToOne(inversedBy: 'measurings')]
    private ?Wine $Wine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getSensor(): ?Sensor
    {
        return $this->Sensor;
    }

    public function setSensor(?Sensor $Sensor): static
    {
        $this->Sensor = $Sensor;

        return $this;
    }

    public function getWine(): ?Wine
    {
        return $this->Wine;
    }

    public function setWine(?Wine $Wine): static
    {
        $this->Wine = $Wine;

        return $this;
    }
}
