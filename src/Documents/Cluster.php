<?php

namespace Documents;

class Cluster extends \Purekid\Mongodm\Model 
{
  static $collection = "cluster";

  protected static $attrs = array(
    'name'      => array('type'=>'string'),
    'layers'    => array('model'=> 'Documents\Host', 'type'=>'embeds')
  );
}
