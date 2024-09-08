<?php

namespace App\Controller;

use App\Service\WineService;
use Exception;
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
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {

            $wines = $this->service->list();

        } catch (Exception) {

            return new JsonResponse("The wines couldn't be recovered");
        }

        return new JsonResponse($wines);
    }


    /**
     * Creates a new wine.
     *
     * Creates a new wine in the database with the data passed through the request.
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {

            $wine = $this->service->create($request->request->all());

        } catch (Exception) {

            return new JsonResponse("There was an error while creating the wine");
        }

        return new JsonResponse('New wine created with the id: ' . $wine->getId());
    }


    /**
     * Update an existing wine
     *
     * Updates an existing wine in the database with the data passed through the request.
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        try {

            $wine = $this->service->update($id, $request->request->all());

        } catch (Exception) {

            return new JsonResponse("There was an error while updating the wine");
        }

        if (!$wine) {

            return new JsonResponse('The wine to update couldn\'t be found', 404);
        }

        return new JsonResponse('The wine with the id ' . $wine->getId() . ' was successfully updated');

    }


    /**
     * Delete an existing wine
     *
     * Deletes an existing wine in the database.
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {

            $wine = $this->service->delete($id);

        } catch (Exception) {

            return new JsonResponse("There was an error while deleting the wine");
        }

        if (!$wine) {

            return new JsonResponse('The wine to delete couldn\'t be found', 404);
        }

        return new JsonResponse('The wine was successfully deleted');
    }
}
