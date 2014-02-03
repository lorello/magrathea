<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UsersController
{

    protected $usersService;

    public function __construct($service)
    {
        $this->usersService = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->usersService->getAll());
    }

    public function save(Request $request)
    {
        $user = $this->getDataFromRequest($request);
        $id = $this->usersService->save($user);
        return new JsonResponse(array("id" => $id));
    }

    public function update($id, Request $request)
    {
        $user = $this->getDataFromRequest($request);
        $this->usersService->update($id, $user);
        return new JsonResponse($user);
    }

    public function delete($id)
    {
        return new JsonResponse($this->usersService->delete($id));
    }

    private function getDataFromRequest(Request $request)
    {
        return $user = array(
            'user' => $request->request->get('user')
        );
    }
}
