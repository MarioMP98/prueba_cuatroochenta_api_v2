<?php

namespace App\Traits;

trait CollectionParser
{
    public function parseCollection($collection): array
    {
        $array = array();

        foreach ($collection->getIterator() as $item) {
            $decorator = $collection->getDecorator($item);
            $array[] = $decorator->parse();
        }

        return $array;
    }
}
