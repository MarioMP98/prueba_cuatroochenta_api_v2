<?php

namespace App\Factory;

use App\Entity\Wine;
use App\Interface\WineAbstractFactory;
use App\Interface\WineInterface;

class WineFactory implements WineAbstractFactory
{
    public function createWine(): WineInterface
    {
        return new Wine();
    }
}