<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NodesController extends BaseController
{
    public function getDataFromRequest(Request $request)
    {
        return array(
            'name'     => $request->request->get('name'),
            'fqdn'     => $request->request->get('fqdn'),
            'username' => $this->getCurrentUser()
        );
    }
}