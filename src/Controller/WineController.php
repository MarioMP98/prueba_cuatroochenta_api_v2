<?php

namespace App\Controller;

use App\Request\WineRequest;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {

            $wines = $this->service->list($request->query->all());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while recovering the wines: " . $e->getMessage(),
                $e->getCode() ?: 500
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
    public function create(WineRequest $request): JsonResponse
    {
        try {

            $wine = $this->service->create($request->getParams());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while creating the wine: " . $e->getMessage(),
                $e->getCode() ?: 500
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
    public function update($id, Request $request): JsonResponse
    {
        try {

            $wine = $this->service->update($id, $request->request->all());

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while updating the wine: " . $e->getMessage(),
                $e->getCode() ?: 500
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
    public function delete($id, $soft = true): JsonResponse
    {
        try {

            $wine = $this->service->delete($id, $soft);

        } catch (Exception $e) {

            return new JsonResponse(
                "There was an error while deleting the wine: " . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }

        if (!$wine) {

            return new JsonResponse('The wine to delete couldn\'t be found', 404);
        }

        return new JsonResponse('The wine was successfully deleted');
    }
}
