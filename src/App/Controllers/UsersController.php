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
        try {
            $result = $this->usersService->save($user);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }
        $id = (string)$result;

        return new JsonResponse(array(
            "id"       => $id,
            'name'     => $user['name'],
            'email'    => $user['email'],
            'password' => '****'
        ), 201);
    }

    public function update($id, Request $request)
    {
        $data = $this->getDataFromRequest($request);

        try {
            $result = $this->usersService->update($id, $data);
        } catch (Exception $e) {
            // TODO: Should I return 404 if user does not exists?
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        return new JsonResponse(array(
            "id"       => $id,
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => '****'
        ), 200);
    }

    public function delete($id)
    {
        try {
            $result = $this->usersService->delete($id);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        return new JsonResponse($result);
    }

    public function login($email, $password)
    {
        $user = User::getByEmail($email);
        if (!$user) {
            throw new \Exception("User with email '$name' not found");
        }
        if (password_verify($password, $user->getPassword())) {
            return true;
        }

        return false;
    }

    private function getDataFromRequest(Request $request)
    {
        return array(
            'name'     => $request->request->get('name'),
            'email'    => $request->request->get('email'),
            'password' => $request->request->get('password')
        );
    }
}