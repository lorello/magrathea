<?php

namespace Documents;

class User extends \Purekid\Mongodm\Model
{
    static $collection = "users";

    protected static $attrs = array(
        'name'     => array('default' => 'anonym', 'type' => 'string'),
        'email'    => array('type' => 'string'),
        'password' => array('type' => 'string')
    );

    function setName($value)
    {
        if (empty($value)) {
            throw new \Exception('User name cannot be empty');
        }
        if (!preg_match('/[a-z][a-z0-9]{3,32}/', $value)) {
            throw new \Exception('Username must be between 3 and 32 characters long and must contains only letters and numbers');
        }
        $this->__setter('name', $value);
    }

    function setEmail($value)
    {
        if (empty($value)) {
            throw new \Exception('Email cannot be empty');
        }
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Email '$value' is not valid");
        }
        if (User::count(array('email' => $value)) > 0) {
            throw new \Exception("Duplicate user with email '$value''");
        }

        return $this->__setter('email', $value);
    }

    function setPassword($value)
    {
        if (empty($value)) {
            throw new \Exception('User password cannot be empty');
        }
        # TODO: find a good regexp for password
        if (!preg_match('/[A-Za-z0-9?=:;,_-]{8,32}/', $value)) {
            throw new \Exception('Password must be between 8 and 32 characters long and valid characters are letters, numbers and symbols ?=:;,_-');
        }
        // TODO: get password_compat if PHP < 5.5
        $this->__setter('password', password_hash($value, PASSWORD_DEFAULT));
    }
}
