<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFactory
{
    public function createUser(): UserInterface
    {
        return new User();
    }
}
