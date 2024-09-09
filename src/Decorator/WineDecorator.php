<?php

namespace App\Decorator;

use App\Entity\Wine;
use App\Interface\WineInterface;

class WineDecorator implements WineInterface
{
    protected Wine $wine;

    public function __construct(Wine $wine)
    {
        $this->wine = $wine;
    }

    public function parse(): array
    {
        return $this->wine->parse();
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function setName(?string $name)
    {
        // TODO: Implement setName() method.
    }

    public function getYear()
    {
        // TODO: Implement getYear() method.
    }

    public function setYear(?int $year)
    {
        // TODO: Implement setYear() method.
    }
}
