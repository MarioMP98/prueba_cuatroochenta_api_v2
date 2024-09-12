<?php

namespace App\Controller;

use App\Request\UserRequest;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistrationController extends AbstractController
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Lists the existing users.
     *
     * Retrieves and shows a list of all the users in the database.
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $users = $this->service->list();

        return new JsonResponse($users, 200);
    }

    /**
     * Registers a new user.
     *
     * Creates a new user in the database with the data passed through the request.
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        $user = $this->service->create($request->getParams());

        return new JsonResponse($user, 201);
    }
}
