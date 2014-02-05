<?php

namespace Documents;

class User extends \Purekid\Mongodm\Model 
{
    static $collection = "users";

    protected static $attrs = array(
        'name'      => array('default'=>'anonym','type'=>'string'),
        'email'     => array('type'=>'string'),
        'password'  => array('type'=>'string')
    );

    function setName($value) {
        if (empty($value))
            throw new Exception('User name cannot be empty');
        if (!preg_match('/[a-z][a-z0-9]{3,}/',$value))
            throw new Exception('Only letters and numbers are valid username characters');
        $this->__setter('name', $value);
    }

    function setEmail($value) {
        if (empty($value))
            throw new Exception('Email cannot be empty');
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->__setter('email', $value);
        }
    }

    function setPassword($value) {
        if (empty($value))
            throw new Exception('User password cannot be empty');
        # TODO: find a good regexp for password
        if (!preg_match('/[A-Za-z0-9?=:;,_-]{8,}/',$value))
        $this->__setter('password', $value(pot));
    }
}
