<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController implements ControllerInterface
{

    protected $service;
    protected $security;

    # TODO: Add types on parameters
    public function __construct($service, $security)
    {
        $this->service  = $service;
        $this->security = $security;
    }

    public function get($id)
    {
        return new JsonResponse($this->service->get($id));
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

    public function getCurrentUser()
    {
        $token = $this->security->getToken();

        if ($token === null) {
            throw new \Exception("Operation not permitted as anonymous user, please login first.");
        }

        $sfUser = $token->getUser();
        if (!$sfUser->isEnabled()) {
            throw new \Exception("Operation not permitted for unconfirmed user, please activate your account first.");
        }

        return $sfUser->getUsername();
    }
}