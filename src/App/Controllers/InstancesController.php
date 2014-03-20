<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InstancesController extends BaseController
{
    public function getDataFromRequest(Request $request)
    {
        return array(
            'name'      => $request->request->get('name'),
            'app'       => $request->request->get('app'),
            'cluster'   => $request->request->get('cluster'),
            'owner'     => $this->getCurrentUser()
        );
    }
}