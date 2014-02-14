<?php

namespace App\Services;

use Documents\App;
use Documents\User;

class AppsService extends BaseService
{
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
        return App::one(array('name' => $value));
    }

    public function getAll()
    {
        $items  = App::all();
        $result = array();
        foreach ($items as $item) {
            $result[] = array(
                'id'    => (string)$item->getId(),
                'name'  => $item->getName(),
                'owner' => $item->getOwner(),
                'conf'  => $item->getConf()
            );
        }

        return $result;
    }

    public function save($data)
    {
        $owner = User::id($data['owner']);
        if (!$owner instanceof User) {
            throw new \Exception("Cannot find App owner '$data[owner]''");
        }
        $item = new App();
        $item->setName($data['name']);
        $item->setOwner($owner);
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
}