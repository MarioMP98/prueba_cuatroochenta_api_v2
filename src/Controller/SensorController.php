<?php

namespace App\Controller;

use App\Service\SensorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SensorController extends AbstractController
{
    protected $service;


    public function __construct(SensorService $service)
    {
        $this->service = $service;
    }


    /**
     * Lists the existing sensors.
     *
     * Retrieves and shows a list of all the sensors in the database, ordered alphabetically by name.
     */
    public function list(): JsonResponse
    {
        /* try { */

            $sensor = $this->service->list();

        /* } catch (\Exception) {

            return new JsonResponse("The sensors couldn't be recovered");
        } */

        return new JsonResponse($sensor);
    }


    /**
     * Creates a new sensor.
     *
     * Creates a new sensor in the database with the data passed through the request.
     */
    public function create(Request $request): JsonResponse
    {
        /* try { */

            $sensor = $this->service->create($request->request->all());

        /* } catch (\Exception) {

            return new JsonResponse("There was an error while creating the sensor");
        } */

        return new JsonResponse('New sensor created with the id: ' . $sensor->getId());
    }


    /**
     * Update an existing sensor
     *
     * Updates an existing sensor in the database with the data passed through the request.
     */
    public function update($id, Request $request): JsonResponse
    {
        try {

            $sensor = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("There was an error while updating the sensor");
        }

        if (!$sensor) {

            return new JsonResponse('The sensor to update couldn\'t be found');
        }

        return new JsonResponse('The sensor with the id ' . $sensor->getId() . ' was successfully updated');

    }


    /**
     * Delete an existing sensor
     *
     * Deletes an existing sensor in the database.
     */
    public function delete($id): JsonResponse
    {
        /* try { */
            $sensor = $this->service->delete($id);

        /* } catch (\Exception) {

            return new JsonResponse("There was an error while deleting the sensor");
        } */

        if (!$sensor) {

            return new JsonResponse('The sensor to delete couldn\'t be found');
        }

        return new JsonResponse('The sensor was successfully deleted');
    }
}
