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
        // TODO: missing check for duplicate user email
        $user = $this->getDataFromRequest($request);
        $result = $this->usersService->save($user);
        $id = (string) $result;
        return new JsonResponse(array("id" => $id, 'name'=>$user['name'], 'email'=>$user['email'], 'password'=>'****'), 201);
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
        return array(
                'name'      => $request->request->get('name'),
                'email'     => $request->request->get('email'),
                'password'  => $request->request->get('password')
        );
    }
}