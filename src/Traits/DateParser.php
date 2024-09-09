<?php

namespace App\Traits;

trait DateParser
{
    public function formatDateTime($datetime): string|null
    {
        return $datetime ? $datetime->format('d/m/Y H:i:s') : null;
    }
}
