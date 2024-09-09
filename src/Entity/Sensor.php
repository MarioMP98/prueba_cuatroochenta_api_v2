<?php

namespace App\Entity;

use App\Interface\SensorInterface;
use App\Repository\SensorRepository;
use App\Traits\DateParser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor implements SensorInterface
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use DateParser;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Measuring>
     */
    #[ORM\OneToMany(targetEntity: Measuring::class, mappedBy: 'sensor')]
    private Collection $measurings;

    public function __construct()
    {
        $this->measurings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Measuring>
     */
    public function getMeasurings(): Collection
    {
        return $this->measurings;
    }

    public function addMeasuring(Measuring $measuring): static
    {
        if (!$this->measurings->contains($measuring)) {
            $this->measurings->add($measuring);
            $measuring->setSensor($this);
        }

        return $this;
    }

    public function removeMeasuring(Measuring $measuring): static
    {
        if ($this->measurings->removeElement($measuring) && $measuring->getSensor() === $this) {
            // set the owning side to null (unless already changed)
            $measuring->setSensor(null);
        }

        return $this;
    }

    public function parse(): array
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->formatDateTime($this->createdAt),
            'updated_at' => $this->formatDateTime($this->updatedAt),
            'deleted_at' => $this->formatDateTime($this->deletedAt)
        );
    }
}
