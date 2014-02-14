<?php

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\Security\Core\User\User as AdvancedUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

# TODO: Add extends BaseController
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
            "id"    => $id,
            'name'  => $user['name'],
            'email' => $user['email'],
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
            "id"    => $id,
            'name'  => $data['name'],
            'email' => $data['email'],
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

    private function encryptPassword(Application $app, $username, $password)
    {
        // Empty password become unempty encrypted password, so I check here;
        // the check on the usersService is not reached anytime :-(
        if (empty($password)) {
            throw new \Exception("Password cannot be empty");
        }

        // find the encoder for a UserInterface instance
        $u       = new  AdvancedUser($username, $password);
        $encoder = $app['security.encoder_factory']->getEncoder($u);

        // compute the encoded password
        return $encoder->encodePassword($password, $u->getSalt());
    }

    public function register(Request $request, Application $app)
    {
        $data = $this->getDataFromRequest($request);

        // check if user is already registerd
        $user = $this->usersService->getByEmail($data['email']);
        if ($user instanceof \Documents\User) {
            throw new \Exception("User with email '$data[email]' already registered");
        }

        $data['password'] = $this->encryptPassword($app, $data['name'], $data['password']);

        // create activation key and send email
        $data['activation_key'] = new \MongoId();

        try {
            $result = $this->usersService->save($data);
            $id     = (string)$result;
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }
        mail(
            $data['email'],
            'Welcome on Magrathea' . $data['name'],
            'Confirm your email address ' . $data['email'] . ' invoking thinkdeep with the command:\ntd user-activate ' . $data['activation_key'] . "\n\n"
        );

        return new JsonResponse(array(
            'id'      => $id,
            'name'    => $data['name'],
            'email'   => $data['email'],
            'message' => 'Check your email for activation code',
        ), 201);
    }


    public function activate($activation_key)
    {
        try {
            $id = $this->usersService->isActivable($activation_key);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 403);
        }

        $data['enabled']        = true;
        $data['activation_key'] = '';
        try {
            $this->usersService->update($id, $data);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        return new JsonResponse(array('message' => 'Account activated'));
    }

    private function getDataFromRequest(Request $request)
    {
        return array(
            'name'     => $request->request->get('name'),
            'email'    => $request->request->get('email'),
            'password' => $request->request->get('password'),
        );
    }
}