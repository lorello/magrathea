<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class InstancesController extends BaseController
{
    public function getDataFromRequest(Request $request)
    {
        return [
            'name'      => $request->request->get('name'),
            'app'       => $request->request->get('app'),
            'cluster'   => $request->request->get('cluster'),
            'owner'     => $this->getCurrentUser(),
        ];
    }
}
