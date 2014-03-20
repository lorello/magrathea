<?php

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\Security\Core\User\User as AdvancedUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends BaseController
{
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

        if (empty($data['email'])) {
            throw new \Exception("Parameter email is required");
        }

        // check if user is already registerd
        $user = $this->service->getByEmail($data['email']);
        if ($user instanceof \Documents\User) {
            throw new \Exception("User with email '$data[email]' already registered");
        }

        $data['password'] = $this->encryptPassword($app, $data['name'], $data['password']);

        // create activation key and send email
        $data['activation_key'] = new \MongoId();

        try {
            $result = $this->service->save($data);
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
            $id = $this->service->isActivable($activation_key);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 403);
        }

        $data['enabled']        = true;
        $data['activation_key'] = '';
        try {
            $this->service->update($id, $data);
        } catch (Exception $e) {
            return new JsonResponse(array('message' => $e->getMessage()), 500);
        }

        return new JsonResponse(array('message' => 'Account activated'));
    }

    public function getDataFromRequest(Request $request)
    {
        return array(
            'name'     => $request->request->get('name'),
            'email'    => $request->request->get('email'),
            'password' => $request->request->get('password'),
        );
    }
}