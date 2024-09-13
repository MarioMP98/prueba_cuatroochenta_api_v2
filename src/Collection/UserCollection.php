<?php

namespace App\Collection;

use App\Decorator\UserDecorator;
use App\Iterator\CustomIterator;
use Iterator;
use IteratorAggregate;

class UserCollection implements IteratorAggregate
{
    private array $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function getIterator(): Iterator
    {
        return new CustomIterator($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new CustomIterator($this, true);
    }

    public function getDecorator($item): UserDecorator
    {
        return new UserDecorator($item);
    }
}
