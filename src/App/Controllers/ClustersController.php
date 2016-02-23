<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ClustersController extends BaseController
{
    public function getDataFromRequest(Request $request)
    {
        return [
            'name'     => $request->request->get('name'),
            'username' => $this->getCurrentUser(),
        ];
    }

    public function addNode($cluster_id, $layer_name, $node_id)
    {
        return new JsonResponse($this->service->addNode($cluster_id, $layer_name, $node_id));
    }
}
