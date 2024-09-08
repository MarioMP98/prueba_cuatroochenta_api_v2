<?php

namespace App\Factory;

use App\Entity\Wine;
use App\Interface\WineInterface;

class WineFactory
{
    public function createWine(): WineInterface
    {
        return new Wine();
    }
}
