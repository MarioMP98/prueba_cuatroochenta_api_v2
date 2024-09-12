<?php

namespace App\Decorator;

class MeasuringWithRelationshipDecorator extends MeasuringDecorator
{
    public function parse(): array
    {
        $measuring = $this->measuring->parse();

        if ($this->measuring->getSensor()) {
            $sensorDecorator = new SensorDecorator($this->measuring->getSensor());
            $measuring['sensor'] = $sensorDecorator->parse();
        }

        if ($this->measuring->getWine()) {
            $wineDecorator = new WineDecorator($this->measuring->getWine());
            $measuring['wine'] = $wineDecorator->parse();
        }

        return $measuring;
    }
}
