<?php

namespace Tests\Services;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Wildsurfer\Provider\MongodmServiceProvider;
use Purekid\Mongodm\MongoDB;

use App\Services\NodesService;
use Documents\Node;


date_default_timezone_set('Europe/Rome');


class NodesServiceTest extends \PHPUnit_Framework_TestCase
{

    private $nodeService;

    public function setUp()
    {

        $app = new Application();
        require __DIR__ . '/../../resources/config/test.php';
        $app->register(
            new MongodmServiceProvider(),
            array(
                "mongodm.host"     => $app['config.mongo.host'],
                "mongodm.db"       => $app['config.mongo.db'],
                "mongodm.username" => $app['config.mongo.username'],
                "mongodm.password" => $app['config.mongo.password'],
                "mongodm.options"  => $app['config.mongo.options']
            )
        );


        //define("ROOT_PATH", __DIR__ . "/..");

        //$app->register(new ServiceControllerServiceProvider());

        $this->nodesService = new NodesService();

        // prepopulate
        /*$data = array(
            'hostname'  => 'samplehost',
            'fqdn'      => 'samplehost.mydomain.tld'
        );
        $this->nodesService->save($data);
        */
        // TODO: setup indexes on nodes collection?
        Node::drop();
        //$app['mongodm']->nodes->ensureIndex();
    }

    public function testGetAll()
    {
        $data = array();
        $data = $this->nodesService->getAll();
        $this->assertNotNull($data);
    }

    function testSave()
    {
        $data  = array(
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld'
        );
        $data  = $this->nodesService->save($data);
        $nodes = $this->nodesService->getAll();
        $this->assertEquals(1, count($nodes));
    }

    function testUpdate()
    {
        $node = array(
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld'
        );
        $id   = $this->nodesService->save($node);
        $node = array(
            'hostname' => 'testanother',
            'fqdn'     => 'testanother.mydomain.tld'
        );
        $this->nodesService->update($id, $node);
        $data = $this->nodesService->get($id);
        $this->assertEquals('testanother', $data->getHostname());
        $this->assertEquals('testanother.mydomain.tld', $data->getFqdn());
    }

    function testDelete()
    {
        $node = array(
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld'
        );
        $id   = $this->nodesService->save($node);
        $this->nodesService->delete($id);
        $data = $this->nodesService->getAll();
        $this->assertEquals(0, count($data));
    }

}
