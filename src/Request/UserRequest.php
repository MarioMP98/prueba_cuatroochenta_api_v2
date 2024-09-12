<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserRequest extends BaseRequest
{
    #[NotBlank([])]
    #[Email]
    protected $email;

    #[NotBlank([])]
    #[PasswordStrength]
    protected $password;

    #[NotBlank([])]
    protected $name;

    #[NotBlank([])]
    protected $lastName;
}
