<?php

namespace Tests\Services;

use App\Services\NodesService;
use Silex\Application;

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
        $data = [];
        $data = $this->nodesService->getAll();
        $this->assertNotNull($data);
    }

    public function testSave()
    {
        $data = [
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld',
        ];
        $data = $this->nodesService->save($data);
        $nodes = $this->nodesService->getAll();
        $this->assertEquals(1, count($nodes));
    }

    public function testUpdate()
    {
        $node = [
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld',
        ];
        $id = $this->nodesService->save($node);
        $node = [
            'hostname' => 'testanother',
            'fqdn'     => 'testanother.mydomain.tld',
        ];
        $this->nodesService->update($id, $node);
        $data = $this->nodesService->get($id);
        $this->assertEquals('testanother', $data->getHostname());
        $this->assertEquals('testanother.mydomain.tld', $data->getFqdn());
    }

    public function testDelete()
    {
        $node = [
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld',
        ];
        $id = $this->nodesService->save($node);
        $this->nodesService->delete($id);
        $data = $this->nodesService->getAll();
        $this->assertEquals(0, count($data));
    }

    public function testGetByHostname()
    {
        $node = [
            'hostname' => 'testme',
            'fqdn'     => 'testme.mydomain.tld',
        ];
        $id = $this->nodesService->save($node);
        $this->assertEquals($id, $this->nodesService->getByHostname($node['hostname'])->getId());
    }
}
