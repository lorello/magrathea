<?php

namespace Documents;

class User extends \Documents\Base
{
    static $collection = "users";

    protected static $attrs = array(
        'name'           => array('type' => 'string', 'default' => 'anon', 'null' => false),
        'email'          => array('type' => 'string', 'null' => false),
        'password'       => array('type' => 'string', 'null' => false),
        'roles'          => array('type' => 'string', 'default' => 'ROLE_USER', 'null' => false),
        'enabled'        => array('type' => 'boolean', 'default' => false),
        'lastupdate'     => array('type' => 'timestamp', 'autoupdate' => true),
        'activation_key' => array('type' => 'string'),
    );

    public static $reserved_names = array(
        'magrathea',
        'zaphod',
        'arthur',
        'trillian',
        'ford',
        'marvin',
        'vogon',
        'humma',
    );

    // TODO: Should be unique? Should I introduce Organizations concept? Should be unique inside a single org
    function setName($value)
    {
        if (User::count(array('name' => $value)) > 0) {
            throw new \Exception("Duplicate user with name '$value''");
        }

        if (!preg_match('/[a-z][a-z0-9]{3,32}/', $value)) {
            throw new \Exception('Username must be between 3 and 32 characters long and must contains only letters and numbers');
        }

        if (in_array($value, User::$reserved_names)) {
            throw new \Exception("Username '$value' is reserved on this platform, please choose another one");
        }

        return $this->__setter('name', $value);
    }

    function setEmail($value)
    {
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

        return $this->__setter('password', $value);
    }

}
