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
            'name'  => $request->request->get('name'),
            'owner' => $request->request->get('owner'),
            'conf'  => $request->request->get('conf'),
        );
    }
}
