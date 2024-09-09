<?php

namespace App\Entity;

use App\Interface\WineInterface;
use App\Repository\WineRepository;
use App\Traits\DateParser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: WineRepository::class)]
class Wine implements WineInterface
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

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    /**
     * @var Collection<int, Measuring>
     */
    #[ORM\OneToMany(targetEntity: Measuring::class, mappedBy: 'wine')]
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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

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
            $measuring->setWine($this);
        }

        return $this;
    }

    public function removeMeasuring(Measuring $measuring): static
    {
        if ($this->measurings->removeElement($measuring) && $measuring->getWine() === $this) {
            // set the owning side to null (unless already changed)
            $measuring->setWine(null);
        }

        return $this;
    }

    public function parse(): array
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'created_at' => $this->formatDateTime($this->createdAt),
            'updated_at' => $this->formatDateTime($this->updatedAt),
            'deleted_at' => $this->formatDateTime($this->deletedAt)
        );
    }
}
