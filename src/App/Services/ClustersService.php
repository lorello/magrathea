<?php

namespace App\Services;

use Documents\Cluster;
use Documents\Layer;

class ClustersService extends BaseService
{
    private $userService;
    private $instanceService;
    private $nodeService;

    public function __construct($userService, $instanceService, $nodeService)
    {
        $this->userService     = $userService;
        $this->instanceService = $instanceService;
        $this->nodeService     = $nodeService;
    }

    public function get($id)
    {
        $item = Cluster::id($id);
        if (!($item instanceof Cluster)) {
            throw new \Exception("Cannnot find cluster with id '$id''");
        }

        return $item;
    }

    public function getByName($value)
    {
        return Cluster::one(array('name' => $value));
    }

    public function getAll()
    {
        $clusters = Cluster::all();
        $result   = array();
        foreach ($clusters as $item) {
            $result[] = array(
                'id'     => (string)$item->getId(),
                'name'   => $item->getName(),
                'layers' => $item->getLayers(),
                'owner'  => $item->getOwner()
            );
        }

        return $result;
    }

    public function save($data)
    {
        $user = $this->userService->getByName($data['username']);

        $cluster = new Cluster();
        $cluster->setName($data['name']);
        $cluster->setOwner($user);
        $cluster->save();

        // return the MongoId object
        return $cluster->getId();
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
        # TODO: add check for ownership
        $cluster = Cluster::id($id);
        if (!$cluster) {
            throw new \Exception("Cluster with id '$id' not found");
        }

        $cluster->layers = array();
        $cluster->save();

        $layer = new Layer();
        $layer->setIsEmbed(true);
        $layer->name = $layer_name;
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


        return array(
            'id'     => (string)$cluster->getId(),
            'name'   => $cluster->getName(),
            'layers' => $cluster->getLayers()->toArray(),
            'owner'  => $cluster->getOwner(),
        );
    }
}