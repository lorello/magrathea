<?php

namespace App\Services;

use Documents\App;

class AppsService extends BaseService
{
    private $userService;

    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    public function get($id)
    {
        $item = App::id($id);
        if (!($item instanceof App)) {
            throw new \Exception("Cannnot find item with id '$id''");
        }

        return $item;
    }

    public function getByName($value)
    {
        return App::one(['name' => $value]);
    }

    public function getAll()
    {
        $items = App::all();
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'id'    => (string) $item->getId(),
                'name'  => $item->getName(),
                'owner' => $item->getOwner(),
                'conf'  => $item->getConf(),
            ];
        }

        return $result;
    }

    public function save($data)
    {
        $item = new App();
        $item->setName($data['name']);
        $item->setOwner($this->userService->getByName($data['username']));
        $item->setConf($data['conf']);
        $item->save();

        // return the MongoId object
        return $item->getId();
    }

    public function update($id, $data)
    {
        $item = App::id($id);
        if (!$item) {
            throw new \Exception("Item with id '$id' not found");
        }
        $item->update($data);

        return $item->save();
    }

    public function delete($id)
    {
        $item = App::id($id);
        if (!$item) {
            throw new \Exception("Item with id '$id' not found");
        }

        return $item->delete();
    }

    public function connect($id, $instance_id)
    {
        $a = App::id($id);
        if (!$a) {
            throw new \Exception("Application with id '$id' not found");
        }
        $i = Instance::id($instance_id);
        if (!$i) {
            throw new \Exception("Instance with id '$instance_id' not found");
        }
        if (!empty($i->getApp())) {
            throw new \Exception('Instance is already connected to an App, please disconnect it first.');
        }
        if (empty($i->getCluster())) {
            throw new \Exception("Instance id '$instance_id' it's not valid, it has not cluster assigned");
        }
        $data['app'] = $a;
        Instance::update($instance_id, $data);
    }
}
