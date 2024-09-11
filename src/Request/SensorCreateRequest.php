<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;

class SensorCreateRequest extends BaseRequest
{
    #[NotBlank([])]
    protected $name;
}
