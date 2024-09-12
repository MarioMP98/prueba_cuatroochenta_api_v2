<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;

class SensorRequest extends BaseRequest
{
    #[NotBlank([])]
    protected $name;
}
