<?php

namespace App\Controller;

use App\Entity\Measuring;
use App\Request\MeasuringRequest;
use App\Service\MeasuringService;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MeasuringController extends AbstractController
{
    protected MeasuringService $service;

    public function __construct(MeasuringService $service)
    {
        $this->service = $service;
    }


    /**
     * Lists the existing measurings.
     *
     * Retrieves and shows a list of all the measurings in the database, including the wine
     * that was measured and the sensor that was used.
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'The list of measurings',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Measuring::class))
        )
    )]
    #[OA\Parameter(
        name: 'type',
        in: 'path',
        description: 'Filters an specific type of measuring',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'path',
        description: 'Filters the measurings from one specific year',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'isDeleted',
        in: 'path',
        description: 'Brings soft deleted entities',
        schema: new OA\Schema(type: 'bool')
    )]
    #[OA\Tag(name: 'Measuring')]
    public function list(Request $request): JsonResponse
    {
        try {
            $measurings = $this->service->list($request->query->all());
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while recovering the measurings: " . $e->getMessage(),
                500
            );
        }

        return new JsonResponse($measurings);
    }


    /**
     * Creates a new measuring.
     *
     * Creates a new measuring in the database with the data passed through the request.
     * @param MeasuringRequest $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 201,
        description: 'The recently created entity',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Measuring::class))
        )
    )]
    #[OA\Parameter(
        name: 'sensor',
        in: 'query',
        description: 'The id of the sensor that was used for the measuring',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'wine',
        in: 'query',
        description: 'The id of the wine that was measured',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the measuring was done',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'type',
        in: 'query',
        description: 'The type of measuring that is going to be registered
            It can be one of there: "color", "temp" (Temperature), "grad" (graduation), "ph"
            or "all" if you want to save several measures in the same measuring object',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'value',
        in: 'query',
        description: 'If you chose one of the singular measuring types, you just need to
            input the corresponding value in this field.',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'color',
        in: 'query',
        description: 'The coloration of the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'temperature',
        in: 'query',
        description: 'The temperature in celsius the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'graduation',
        in: 'query',
        description: 'The level of alcoholic graduation the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'ph',
        in: 'query',
        description: 'The PH level the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Tag(name: 'Measuring')]
    public function create(MeasuringRequest $request): JsonResponse
    {
        try {
            $measuring = $this->service->create($request->getParams());
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while creating the measuring: " . $e->getMessage(),
                500
            );
        }

        return new JsonResponse($measuring, 201);
    }


    /**
     * Update an existing measuring
     *
     * Updates an existing measuring in the database with the data passed through the request.
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'The updated entity with the new values',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Measuring::class))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        description: 'The id of the measuring to update',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'sensor',
        in: 'query',
        description: 'The id of the sensor that was used for the measuring',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'wine',
        in: 'query',
        description: 'The id of the wine that was measured',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'year',
        in: 'query',
        description: 'The year the measuring was done',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'value',
        in: 'query',
        description: 'If you chose one of the singular measuring types, you just need to
            input the corresponding value in this field.',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'color',
        in: 'query',
        description: 'The coloration of the wine',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'temperature',
        in: 'query',
        description: 'The temperature in celsius the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'graduation',
        in: 'query',
        description: 'The level of alcoholic graduation the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Parameter(
        name: 'ph',
        in: 'query',
        description: 'The PH level the wine had during the measuring',
        schema: new OA\Schema(type: 'float')
    )]
    #[OA\Tag(name: 'Measuring')]
    public function update($id, Request $request): JsonResponse
    {
        try {
            $measuring = $this->service->update($id, $request->query->all());
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while updating the measuring: " . $e->getMessage(),
                500
            );
        }

        if (!$measuring) {
            return new JsonResponse('The measuring to update couldn\'t be found', 404);
        }

        return new JsonResponse($measuring);
    }


    /**
     * Delete an existing measuring
     *
     * Deletes an existing measuring in the database.
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
        description: 'The id of the measuring to delete',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'soft',
        in: 'path',
        description: 'Determines if the entity is soft deleted or fully deleted',
        schema: new OA\Schema(type: 'bool')
    )]
    #[OA\Tag(name: 'Measuring')]
    public function delete($id, $soft = true): JsonResponse
    {
        try {
            $measuring = $this->service->delete($id, $soft);
        } catch (Exception $e) {
            return new JsonResponse(
                "There was an error while deleting the measuring: " . $e->getMessage(),
                500
            );
        }

        if (!$measuring) {
            return new JsonResponse('The measuring to delete couldn\'t be found', 404);
        }

        return new JsonResponse('The measuring was successfully deleted');
    }
}
