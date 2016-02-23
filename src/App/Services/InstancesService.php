<?php

namespace App\Services;

use Documents\Instance;

class InstancesService extends BaseService
{
    public function get($id)
    {
        $item = Instance::id($id);
        if (!($item instanceof Instance)) {
            throw new \Exception("Cannnot find instance with id '$id''");
        }

        return $item;
    }

    public function getByName($value)
    {
        return Instance::one(['name' => $value]);
    }

    public function getAll()
    {
        $items = Instance::all();
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'id'      => (string) $item->getId(),
                'name'    => $item->getName(),
                'app'     => $item->getApp(),
                'cluster' => $item->getCluster(),
            ];
        }

        return $result;
    }

    public function save($data)
    {
        $item = new Instance();
        $item->setName($data['name']);
        $item->setApp($data['app']);
        $item->setCluster($data['cluster']);
        $item->save();

        // return the MongoId object
        return $item->getId();
    }

    public function update($id, $data)
    {
        $item = Instance::id($id);
        if (!$item) {
            throw new \Exception("Item with id '$id' not found");
        }
        $item->update($data);

        return $item->save();
    }

    public function delete($id)
    {
        $item = Instance::id($id);
        if (!$item) {
            throw new \Exception("Instance with id '$id' not found");
        }

        return $item->delete();
    }
}
