<?php

namespace App\Services;

use Documents\Cluster;

class ClustersService extends BaseService
{
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
        $cluster = new Cluster();
        $cluster->setName($data['name']);
        $cluster->setLayers($data['layers']);
        $cluster->setOwner($data['owner']);
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
}