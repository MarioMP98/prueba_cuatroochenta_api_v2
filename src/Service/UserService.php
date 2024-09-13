<?php

namespace App\Service;

use App\Assembler\UserAssembler;
use App\Collection\UserCollection;
use App\Decorator\UserDecorator;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Traits\CollectionParser;

class UserService
{
    use CollectionParser;

    protected UserRepository $repository;
    protected UserFactory $factory;
    protected UserAssembler $assembler;

    public function __construct(
        UserRepository $repository,
        UserFactory $factory,
        UserAssembler $assembler,
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->assembler = $assembler;
    }

    public function list(): array
    {
        $users = new UserCollection($this->repository->findAll());

        return $this->parseCollection($users);
    }

    public function create($params): array
    {
        $user = $this->factory->createUser();
        $this->assembler->assignValues($user, $params);

        $this->repository->create($user);

        $decorator = new UserDecorator($user);
        return $decorator->parse();
    }
}
