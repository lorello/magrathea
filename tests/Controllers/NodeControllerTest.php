<?php

namespace Tests\Controllers;

use Silex\Application;
use Silex\WebTestCase;

class NodeControllerTest extends WebTestCase
{

    public function createApplication()
    {
        putenv('APPLICATION_ENV', 'testing');


        // I'm using sessions?
        // $app['session.test'] = true;
        $app = new \Silex\Application();

        require __DIR__ . '/../../resources/config/test.php';

        return require __DIR__ . '/../../src/app.php';
    }

    public function testNodeCreate()
    {
        $client  = $this->createClient();
        $crawler = $client->request(
            'GET',
            '/',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
            )
        );
        /*
            $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        */
        $this->assertTrue($client->getResponse()->isOk());
        //$this->assertCount(1, $crawler->filter('h1:contains("Contact us")'));
        //$this->assertCount(1, $crawler->filter('form'));
    }
}