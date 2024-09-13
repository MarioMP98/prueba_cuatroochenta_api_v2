<?php

namespace App\Decorator;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserDecorator implements UserInterface
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function parse(): array
    {
        return $this->user->parse();
    }

    public function getRoles(): array
    {
        // Implementado para evitar exceptions
    }

    public function eraseCredentials(): void
    {
        // Implementado para evitar exceptions
    }

    public function getUserIdentifier(): string
    {
        // Implementado para evitar exceptions
    }
}
