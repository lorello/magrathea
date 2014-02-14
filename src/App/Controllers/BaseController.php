<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController implements ControllerInterface
{

    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->service->getAll());
    }

    public function save(Request $request)
    {
        $data = $this->getDataFromRequest($request);
        try {
            // return object MondoId
            $id = $this->service->save($data);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        $item = $this->service->get($id);

        return new JsonResponse($item->toArray(), 201);
    }

    public function update($id, Request $request)
    {
        $data = $this->getDataFromRequest($request);

        try {
            $result = $this->service->update($id, $data);
        } catch (Exception $e) {
            // TODO: Should I return 404 if user does not exists?
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }
        $item = $this->service->get($id);

        return new JsonResponse($item->toArray(), 200);
    }

    public function delete($id)
    {
        try {
            $result = $this->service->delete($id);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        return new JsonResponse($result);
    }

}