<?php

namespace Documents;

class App extends \Purekid\Mongodm\Model 
{
  static $collection = "app";

  protected static $attrs = array(
    'name'      => array('type'=>'string'),
    'owner'     => array('type'=>'reference'),
    'users'     => array('type'=>'references'),
    'c_at'      => array('type'=>'timestamp'),
    'u_at'      => array('type'=>'timestamp'),
    'conf'      => array('type'=>'string'),
  );
}
