<?php

namespace App\Controller;

use App\Entity\Sensor;
use App\Request\SensorRequest;
use App\Service\SensorService;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SensorController extends AbstractController
{
    protected SensorService $service;


    public function __construct(SensorService $service)
    {
        $this->service = $service;
    }


    /**
     * Lists the existing sensors.
     *
     * Retrieves and shows a list of all the sensors in the database, ordered alphabetically by name.
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'The list of sensors',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Sensor::class))
        )
    )]
    #[OA\Parameter(
        name: 'isDeleted',
        in: 'path',
        description: 'Brings soft deleted entities as well',
        schema: new OA\Schema(type: 'bool')
    )]
    #[OA\Tag(name: 'Sensor')]
    public function list(Request $request): JsonResponse
    {
        try {

            $sensor = $this->service->list($request->query->all());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while recovering the sensors: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }

        return new JsonResponse($sensor);
    }


    /**
     * Creates a new sensor.
     *
     * Creates a new sensor in the database with the data passed through the request.
     * @param SensorRequest $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 201,
        description: 'The recently created entity',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Sensor::class))
        )
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the sensor',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Sensor')]
    public function create(SensorRequest $request): JsonResponse
    {
        try {

            $sensor = $this->service->create($request->getParams());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while creating the sensor: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }

        return new JsonResponse($sensor, 201);
    }


    /**
     * Update an existing sensor
     *
     * Updates an existing sensor in the database with the data passed through the request.
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Response(
        response: 200,
        description: 'The updated entity with the new values',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Sensor::class))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        description: 'The id of the sensor to update',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'A name to assign to the sensor',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Sensor')]
    public function update($id, Request $request): JsonResponse
    {
        try {

            $sensor = $this->service->update($id, $request->request->all());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while updating the sensor: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }

        if (!$sensor) {

            return new JsonResponse('The sensor to update couldn\'t be found', 404);
        }

        return new JsonResponse($sensor);

    }


    /**
     * Delete an existing sensor
     *
     * Deletes an existing sensor in the database.
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
        description: 'The id of the sensor to delete',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'soft',
        in: 'path',
        description: 'Determines if the entity is soft deleted or fully deleted',
        schema: new OA\Schema(type: 'bool')
    )]
    #[OA\Tag(name: 'Sensor')]
    public function delete($id, $soft = true): JsonResponse
    {
        try {
            $sensor = $this->service->delete($id, $soft);

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while deleting the sensor: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }

        if (!$sensor) {

            return new JsonResponse('The sensor to delete couldn\'t be found', 404);
        }

        return new JsonResponse('The sensor was successfully deleted');
    }
}
