<?php

namespace App\Decorator;

class MeasuringWithRelationshipDecorator extends MeasuringDecorator
{
    public function parse(): array
    {
        $measuring = $this->measuring->parse();

        $sensorDecorator = new SensorDecorator($this->measuring->getSensor());
        $wineDecorator = new WineDecorator($this->measuring->getWine());

        $measuring['sensor'] = $sensorDecorator->parse();
        $measuring['wine'] = $wineDecorator->parse();

        return $measuring;
    }
}
