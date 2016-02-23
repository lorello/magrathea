<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class NodesController extends BaseController
{
    public function getDataFromRequest(Request $request)
    {
        return [
            'name'     => $request->request->get('name'),
            'fqdn'     => $request->request->get('fqdn'),
            'username' => $this->getCurrentUser(),
        ];
    }
}
