<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;

class WineUpdateRequest extends BaseRequest
{

    #[Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    protected $year;
}
