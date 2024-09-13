<?php

namespace App\Assembler;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class UserAssembler
{
    protected UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function assignValues($user, $params): void
    {
        $user->setEmail($params['email']);
        $user->setName($params['name']);
        $user->setLastName($params['lastName']);

        $plaintextPassword = $params['password'];
        $hashedPassword = $this->hasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

        if (is_null($user->getId())) {
            $user->setCreatedAt(new DateTime());
        }

        $user->setUpdatedAt(new DateTime());
    }
}
