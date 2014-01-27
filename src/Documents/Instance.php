<?php

namespace Documents;

class Instance extends \Purekid\Mongodm\Model
{
  static $collection = "instance";

  protected static $attrs = array(
    'id'        => array('type' =>'string'),
    'app'       => array('model'=> 'Documents\App',     'type'=>'reference'),
    'cluster'   => array('model'=> 'Documents\Cluster', 'type'=>'reference'),
    'c_at'      => array('type' => 'timestamp'),
    'u_at'      => array('type' => 'timestamp'),
  );
}
