<?php

namespace App\Services;

use Documents\Cluster;
use Documents\Layer;

class ClustersService extends BaseService
{
    private $userService;
    private $instanceService;
    private $nodeService;

    public function __construct(UsersService $userService, InstancesService $instanceService, NodesService $nodeService)
    {
        $this->userService = $userService;
        $this->instanceService = $instanceService;
        $this->nodeService = $nodeService;
    }

    public function get($id)
    {
        $item = Cluster::id($id);
        if (!($item instanceof Cluster)) {
            throw new \Exception("Cannnot find cluster with id '$id''");
        }
        $u = $item->getOwner();
        // debug: var_dump($u);
        return $item;
    }

    public function getByName($value)
    {
        return Cluster::one(['name' => $value]);
    }

    public function getAll()
    {
        $clusters = Cluster::all();
        $result = [];
        foreach ($clusters as $item) {
            $result[] = [
                'id'     => (string) $item->getId(),
                'name'   => $item->getName(),
                'layers' => $item->getLayers(),
                'owner'  => $item->getOwner(),
            ];
        }

        return $result;
    }

    public function save($data)
    {
        $item = new Cluster();
        $item->setName($data['name']);
        $user = $this->userService->getByName($data['username']);
        $item->setOwner($user);
        $item->save();

        $ref = $item->getOwner();
        //var_dump($ref);
        // return the MongoId object
        return $item->getId();
    }

    public function update($id, $data)
    {
        $cluster = Cluster::id($id);
        if (!$cluster) {
            throw new \Exception("Cluster with id '$id' not found");
        }
        $cluster->update($data);

        return $cluster->save();
    }

    public function delete($id)
    {
        $cluster = Cluster::id($id);
        if (!$cluster) {
            throw new \Exception("Cluster with id '$id' not found");
        }

        return $cluster->delete();
    }

    public function getNodeLayer($node)
    {
        foreach ($this->layers as $layer) {
            if ($layer->nodes->has($node)) {
                return $layer;
            }
        }

        return false;
    }

    public function addNode($id, $layer_name, $node_id)
    {
        // TODO: add check for ownership
        $cluster = Cluster::id($id);

        if (!$cluster) {
            throw new \Exception("Cluster with id '$id' not found");
        }

        //var_dump($cluster->owner->name);
        //$cluster->layers = array();
        //$cluster->save();

        $layer = new Layer();
        $layer->setIsEmbed(true);
        $layer->name = $layer_name;
        $cluster->layer = $layer;

        $cluster->layers = \Purekid\Mongodm\Collection::make([$layer]);

        $cluster->save();

        /*
         if (!$cluster->layers->has($layer)) {
            $cluster->layers->add($layer);
            $cluster->save();
        }

        $node = $this->nodeService->Get($node_id);
        if (!$node) {
            throw new \Exception("Node must exists before adding to a cluster, but node with id '$id' does not exists");
        }

        if ($l = $this->getNodeLayer($node)) {
            throw new \Exception("Node $node is already part of layer $l");
        }
        $cluster->layers[$layer_name]->add($node);
        */

        return [
            'id'     => (string) $cluster->getId(),
            'name'   => $cluster->getName(),
            'layers' => $cluster->getLayers()->toArray(),
            'owner'  => $cluster->getOwner(),
        ];
    }
}
