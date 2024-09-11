<?php

namespace App\Controller;

use App\Service\MeasuringService;
use Exception;
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
    public function list(Request $request): JsonResponse
    {
        try {

            $measurings = $this->service->list($request->query->all());

        } catch (Exception) {

            return new JsonResponse("The measurings couldn't be recovered");
        }

        return new JsonResponse($measurings);
    }


    /**
     * Creates a new measuring.
     *
     * Creates a new measuring in the database with the data passed through the request.
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {

            $measuring = $this->service->create($request->request->all());

        } catch (Exception) {

            return new JsonResponse("There was an error while creating the measuring");
        }

        return new JsonResponse('New measuring created with the id: ' . $measuring->getId());
    }


    /**
     * Update an existing measuring
     *
     * Updates an existing measuring in the database with the data passed through the request.
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        try {

            $measuring = $this->service->update($id, $request->request->all());

        } catch (Exception) {

            return new JsonResponse("There was an error while updating the measuring");
        }

        if (!$measuring) {

            return new JsonResponse('The measuring to update couldn\'t be found', 404);
        }

        return new JsonResponse('The measuring with the id ' . $measuring->getId() . ' was successfully updated');

    }


    /**
     * Delete an existing measuring
     *
     * Deletes an existing measuring in the database.
     * @param $id
     * @param bool $soft
     * @return JsonResponse
     */

    public function delete($id, $soft = true): JsonResponse
    {
        try {

            $measuring = $this->service->delete($id, $soft);

        } catch (Exception) {

            return new JsonResponse("There was an error while deleting the measuring");
        }

        if (!$measuring) {

            return new JsonResponse('The measuring to delete couldn\'t be found', 404);
        }

        return new JsonResponse('The measuring was successfully deleted');
    }
}
