<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


interface ControllerInterface
{
    public function __construct($service, $security);

    public function getAll();

    public function save(Request $request);

    public function update($id, Request $request);

    public function delete($id);
}