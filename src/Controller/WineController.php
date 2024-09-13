<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Request\WineRequest;
use App\Service\WineService;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WineController extends AbstractController
{
    protected WineService $service;


    public function __construct(WineService $service)
    {
        $this->service = $service;
    }


    /**
     * Lists the existing wines.
     *
     * Retrieves and shows a list of all the wines in the database, including all of their measurings.
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'The list of wines',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Wine::class))
        )
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'path',
        description: 'Filters the wines from one specific year',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'isDeleted',
        in: 'path',
        description: 'Brings soft deleted entities as well',
        schema: new OA\Schema(type: 'bool')
    )]
    #[OA\Tag(name: 'Wine')]
    public function list(Request $request): JsonResponse
    {
        try {
            $wines = $this->service->list($request->query->all());
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while recovering the wines: " . $e->getMessage(),
                500
            );
        }

        return new JsonResponse($wines);
    }


    /**
     * Creates a new wine.
     *
     * Creates a new wine in the database with the data passed through the request.
     * @param WineRequest $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 201,
        description: 'The recently created entity',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Wine::class))
        )
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the wine was made',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'Wine')]
    public function create(WineRequest $request): JsonResponse
    {
        try {
            $wine = $this->service->create($request->getParams());
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while creating the wine: " . $e->getMessage(),
                500
            );
        }

        return new JsonResponse($wine, 201);
    }


    /**
     * Update an existing wine
     *
     * Updates an existing wine in the database with the data passed through the request.
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'The updated entity with the new values',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Wine::class))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        description: 'The id of the wine to update',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the wine was made',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'Wine')]
    public function update($id, Request $request): JsonResponse
    {
        try {
            $wine = $this->service->update($id, $request->query->all());
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while updating the wine: " . $e->getMessage(),
                500
            );
        }

        if (!$wine) {
            return new JsonResponse('The wine to update couldn\'t be found', 404);
        }

        return new JsonResponse($wine);
    }


    /**
     * Delete an existing wine
     *
     * Deletes an existing wine in the database.
     * @param $id
     * @param bool $soft
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'A confirmation message that the entity was successfully deleted',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        description: 'The id of the wine to delete',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'soft',
        in: 'path',
        description: 'Determines if the entity is soft deleted or fully deleted',
        schema: new OA\Schema(type: 'bool')
    )]
    #[OA\Tag(name: 'Wine')]
    public function delete($id, $soft = true): JsonResponse
    {
        try {
            $wine = $this->service->delete($id, $soft);
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while deleting the wine: " . $e->getMessage(),
                500
            );
        }

        if (!$wine) {
            return new JsonResponse('The wine to delete couldn\'t be found', 404);
        }

        return new JsonResponse('The wine was successfully deleted');
    }
}
