<?php

namespace App\Assembler;

use DateTime;

class SensorAssembler
{
    public function assignValues($sensor, $params): void
    {
        if (isset($params['name'])) {
            $sensor->setName($params['name']);
        }

        if (is_null($sensor->getId())) {
            $sensor->setCreatedAt(new DateTime());
        }

        $sensor->setUpdatedAt(new DateTime());
    }

    public function detachMeasurings($sensor): void
    {
        foreach ($sensor->getMeasurings() as $measuring) {
            $sensor->removeMeasuring($measuring);
        }
    }
}
