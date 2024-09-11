<?php

namespace App\Collection;

use App\Decorator\SensorDecorator;
use App\Iterator\CustomIterator;
use Iterator;
use IteratorAggregate;

class SensorCollection implements IteratorAggregate
{
    private array $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        $array = array();

        foreach ($this->items as $item) {
            $decorator = new SensorDecorator($item);
            $array[] = $decorator->parse();
        }

        return $array;
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
}
