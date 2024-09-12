<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;

class WineRequest extends BaseRequest
{
    #[NotBlank()]
    protected $name;
}
