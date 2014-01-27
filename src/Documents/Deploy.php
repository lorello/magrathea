<?php

namespace Documents;

class Deploy extends \Purekid\Mongodm\Model 
{
  static $collection = 'deploy';

  protected static $attrs = array(
    'app'       => array('model'=> 'Documents\App',     'type'=>'reference'),
    'appenv'    => array('model'=> 'Documents\Appenv',  'type'=>'reference'),
    'c_at'      => array('type' => 'timestamp'),
  );
}
