<?php

namespace Tests\Controllers;

use Silex\Application;
use Silex\WebTestCase;

class NodeControllerTest extends WebTestCase
{
    // Interface for WebTestCase
    public function createApplication()
    {
        // I'm using sessions?
        // $app['session.test'] = true;
        $app = new \Silex\Application();

        require __DIR__.'/../../resources/config/test.php';

        return require __DIR__.'/../../src/app.php';
    }

    public function testNodeCreate()
    {
        $client = $this->createClient();
        $crawler = $client->request(
            'GET',
            '/',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertTrue($client->getResponse()->isOk());
    }
}
