<?php

namespace App\Controller;

use App\Request\SensorRequest;
use App\Service\SensorService;
use Exception;
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
