<?php

namespace App\Service;

use App\Decorator\UserDecorator;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class UserService
{
    protected UserRepository $repository;
    protected UserPasswordHasherInterface $hasher;
    protected UserFactory $factory;

    public function __construct(
        UserRepository $repository,
        UserPasswordHasherInterface $hasher,
        UserFactory $factory
    ) {
        $this->repository = $repository;
        $this->hasher = $hasher;
        $this->factory = $factory;
    }

    public function list(): array
    {
        $users = $this->repository->findAll();

        return $this->parseUsers($users);
    }

    public function create($params): array
    {
        $user = $this->factory->createUser();

        $this->assignValues($user, $params);

        $this->repository->save($user);

        $decorator = new UserDecorator($user);

        return $decorator->parse();
    }

    private function assignValues($user, $params): void
    {
        $user->setEmail($params['email']);
        $user->setName($params['name']);
        $user->setLastName($params['last_name']);

        $plaintextPassword = $params['password'];
        $hashedPassword = $this->hasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

        if (is_null($user->getId())) {
            $user->setCreatedAt(new DateTime());
        }

        $user->setUpdatedAt(new DateTime());
    }

    private function parseUsers($users): array
    {
        $array = array();

        foreach ($users as $user) {
            $decorator = new UserDecorator($user);
            $array[] = $decorator->parse();
        }

        return $array;
    }

}
