<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class NodesController
{

    protected $nodesService;

    public function __construct($service)
    {
        $this->nodesService = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->nodesService->getAll());
    }

    public function save(Request $request)
    {
        $data = $this->getDataFromRequest($request);
        try {
            // return object MondoId
            $id = $this->nodesService->save($data);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        $item = $this->nodesService->get($id);

        return new JsonResponse($item->toArray(), 201);
    }

    public function update($id, Request $request)
    {
        $data = $this->getDataFromRequest($request);

        try {
            $result = $this->nodesService->update($id, $data);
        } catch (Exception $e) {
            // TODO: Should I return 404 if user does not exists?
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }
        $item = $this->nodesService->get($id);

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
            'hostname' => $request->request->get('hostname'),
            'fqdn'     => $request->request->get('fqdn')
        );
    }
}