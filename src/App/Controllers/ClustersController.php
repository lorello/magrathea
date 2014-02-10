<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ClustersController
{

    protected $clustersService;

    public function __construct($service)
    {
        $this->clustersService = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->clustersService->getAll());
    }

    public function save(Request $request)
    {
        $data = $this->getDataFromRequest($request);
        try {
            // return object MondoId
            $id = $this->clustersService->save($data);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        $item = $this->clustersService->get($id);

        return new JsonResponse($item->toArray(), 201);
    }

    public function update($id, Request $request)
    {
        $data = $this->getDataFromRequest($request);

        try {
            $result = $this->clustersService->update($id, $data);
        } catch (Exception $e) {
            // TODO: Should I return 404 if user does not exists?
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }
        $item = $this->clustersService->get($id);

        return new JsonResponse($item->toArray(), 200);
    }

    public function delete($id)
    {
        try {
            $result = $this->nodesService->delete($id);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        return new JsonResponse($result);
    }

    private function getDataFromRequest(Request $request)
    {
        return array(
            'name'   => $request->request->get('name'),
            'layers' => $request->request->get('layers'),
        );
    }
}