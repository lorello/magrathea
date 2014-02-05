<?php

namespace App\Services;

use Documents\User;

class UsersService extends BaseService
{
    public function get($id)
    {
        return User::one(array('id' => $id));
    }

    public function getByEmail($value)
    {
        return User::one(array('email' => $value));
    }

    public function getAll()
    {
        $users = User::all();
        foreach ($users as $u) {
            $result[] = array(
                'id'    => (string)$u->getId(),
                'name'  => $u->getName(),
                'email' => $u->getEmail()
            );
        }

        return $result;
    }

    function save($data)
    {
        $user = new User();
        // not needed
        //$user->setName($data['name']);
        //$user->setEmail($data['email']);
        //$user->setPassword($data['password']);
        $user->save($data);

        // return the MongoId object
        return $user->getId();
    }

    function update($id, $data)
    {
        $user = User::id($id);
        if (!$user) {
            throw new \Exception("User with id '$id' not found");
        }
        $user->update($data);

        return $user->save();
    }

    function delete($id)
    {
        $user = User::id($id);
        if (!$user) {
            throw new \Exception("User with id '$id' not found");
        }

        return $user->delete();
    }
}
