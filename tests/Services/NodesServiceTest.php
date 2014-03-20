<?php


namespace Tests\Services;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Wildsurfer\Provider\MongodmServiceProvider;
use Purekid\Mongodm\MongoDB;

use App\Services\NodesService;
use Documents\Node;


class NodesServiceTest extends \PHPUnit_Framework_TestCase
{
    private $nodeService;

    public function setUp()
    {
        $app = new Application();

        $this->nodesService = new NodesService();
        $this->nodesService->init();
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

    function testGetByHostname()
    {
        $node = array(
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld'
        );
        $id   = $this->nodesService->save($node);
        $this->assertEquals($id, $this->nodesService->getByHostname($node['hostname'])->getId());
    }
}
