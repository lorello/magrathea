<?php

namespace Documents;

class Node extends \Purekid\Mongodm\Model
{
  static $collection = "nodes";

  protected static $attrs = array(
    'hostname'  => array('type'=>'string'),
    'fqdn'      => array('type'=>'string')
  );
}