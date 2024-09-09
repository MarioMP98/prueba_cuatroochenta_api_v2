<?php

namespace App\Decorator;

class WineWithMeasuringsDecorator extends WineDecorator
{
    public function parse(): array
    {
        $wine = $this->wine->parse();
        $measurings = $this->wine->getMeasurings();
        $array = array();

        foreach ($measurings as $measuring) {
            $decorator = new MeasuringDecorator($measuring);
            $array[] = $decorator->parse();
        }

        $wine['measurings'] = $array;

        return $wine;
    }
}
