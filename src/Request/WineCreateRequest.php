<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class WineCreateRequest extends BaseRequest
{
    #[NotBlank([])]
    protected $name;

    #[Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    protected $year;
}
