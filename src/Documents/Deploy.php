<?php

namespace Documents;

class Deploy extends \Purekid\Mongodm\Model 
{
  static $collection = 'deploys';

  protected static $attrs = array(
    'app'       => array('model'=> 'Documents\App',     'type'=>'reference'),
    'instance'  => array('model'=> 'Documents\Instance','type'=>'reference'),
    'c_at'      => array('type' => 'timestamp'),
  );
}
