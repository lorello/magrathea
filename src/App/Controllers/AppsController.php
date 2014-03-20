<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AppsController extends BaseController
{
    public function getDataFromRequest(Request $request)
    {
        return array(
            'name'     => $request->request->get('name'),
            'conf'     => $request->request->get('conf'),
            'username' => $this->getCurrentUser()
        );
    }

    public function connect($id, $instance_id)
    {
        $this->service->connect($id, $instance_id)
    }

    public function deploy($id, $instance_id)
    {

    }
}
