<?php

namespace Documents;

class Host extends \Purekid\Mongodm\Model 
{
  static $collection = "host";

  protected static $attrs = array(
    'hostname'  => array('type'=>'string'),
    'fqdn'      => array('type'=>'string')
  );
}
