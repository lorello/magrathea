<?php

namespace App\Services;

use Documents\Node;

class NodesService extends BaseService
{
    public function init()
    {
        $n = new Node();
        $n->drop();
        $n->initCollection();
    }

    public function get($id)
    {
        $item = Node::id($id);
        if (!($item instanceof Node)) {
            throw new \Exception("Cannnot find node with id '$id''");
        }

        return $item;
    }

    public function getByHostname($value)
    {
        return Node::one(array('hostname' => $value));
    }

    public function getAll()
    {
        $nodes  = Node::all();
        $result = array();
        foreach ($nodes as $n) {
            $result[] = array(
                'id'       => (string)$n->getId(),
                'hostname' => $n->getHostname(),
                'fqdn'     => $n->getFqdn()
            );
        }

        return $result;
    }

    public function save($data)
    {
        $node = new Node();
        $node->setHostname($data['hostname']);
        $node->setFqdn($data['fqdn']);
        $node->save();

        // return the MongoId object
        return $node->getId();
    }

    public function update($id, $data)
    {
        $node = Node::id($id);
        if (!$node) {
            throw new \Exception("Node with id '$id' not found");
        }
        $node->update($data);

        return $node->save();
    }

    public function delete($id)
    {
        $node = Node::id($id);
        if (!$node) {
            throw new \Exception("Node with id '$id' not found");
        }

        return $node->delete();
    }
}