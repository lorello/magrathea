<?php

namespace App\Services;

use Documents\User;

class UsersService extends BaseService
{
    public function getAll()
    {
        $users = User::all();
        $s = '';
        foreach($users as $u)
        {
          $s .= $u->getName().' ';
        }
        return $s;
    }

    function save($user)
    {
        $user = new User($user);
        $user->save();
        return $user->getId();
    }

    function update($id, $user)
    {
        $user = User::id($id);
        if(!$user) {
          throw new \Exception("User with id '$id' not found");
        }
        $user->update($user);
        return $user->save();
    }

    function delete($id)
    {
        $user = User::id($id);
        if(!$user) {
          throw new \Exception("User with id '$id' not found");
        }
        $user->delete();
    }
}
