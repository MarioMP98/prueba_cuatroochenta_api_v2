<?php

namespace App\Assembler;

use DateTime;

class WineAssembler
{
    public function assignValues($wine, $params): void
    {
        if (isset($params['year'])) {
            $wine->setYear(intval($params['year']) ?: null);
        }

        if (isset($params['name'])) {
            $wine->setName($params['name']);
        }

        if (is_null($wine->getId())) {
            $wine->setCreatedAt(new DateTime());
        }

        $wine->setUpdatedAt(new DateTime());
    }
}
