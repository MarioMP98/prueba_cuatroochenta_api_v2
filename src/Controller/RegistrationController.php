<?php

namespace App\Controller;

use App\Request\UserRequest;
use App\Service\UserService;
use Exception;
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
        try {

            $users = $this->service->list();

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while recovering the users: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }

        return new JsonResponse($users);
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
        try {

            $user = $this->service->create($request->getParams());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while registering the user: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }


        return new JsonResponse($user, 201);
    }
}
