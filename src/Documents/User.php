<?php

namespace Documents;

class User extends \Purekid\Mongodm\Model 
{
  static $collection = "user";

  protected static $attrs = array(
    'name' => array('default'=>'anonym','type'=>'string'),
    'email' => array('type'=>'string')
  );
}
