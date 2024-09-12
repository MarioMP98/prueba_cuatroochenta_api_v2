<?php

namespace App\Controller;

use App\Entity\User;
use App\Request\UserRequest;
use App\Service\UserService;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
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
    #[OA\Response(
        response: 200,
        description: 'The list of users',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class))
        )
    )]
    #[OA\Tag(name: 'User')]
    public function list(): JsonResponse
    {
        try {

            $users = $this->service->list();

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while recovering the users: " . $e->getMessage(),
                500
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
    #[OA\Response(
        response: 201,
        description: 'The recently created user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class))
        )
    )]
    #[OA\Parameter(
        name: 'email',
        in: 'query',
        description: 'The email that will be used to login. It must be unique.',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'password',
        in: 'query',
        description: 'The password that will be required to login.',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'The user\'s name',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'lastName',
        in: 'query',
        description: 'The user\'s last name or last names',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'User')]
    public function register(UserRequest $request): JsonResponse
    {
        try {

            $user = $this->service->create($request->getParams());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while registering the user: " . $e->getMessage(),
                500
            );
        }


        return new JsonResponse($user, 201);
    }
}
