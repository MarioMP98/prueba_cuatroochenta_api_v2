<?php

namespace App\Factory;

use App\Interface\MeasuringAbstractFactory;

class MeasuringFactorySwitch
{
    public function selectFactory($value): MeasuringAbstractFactory
    {
        return match ($value) {
            "color" => new MeasuringColorFactory(),
            "temp" => new MeasuringTempFactory(),
            "graduation" => new MeasuringGradFactory(),
            "ph" => new MeasuringPhFactory(),
            default => new MeasuringAllFactory(),
        };
    }
}
