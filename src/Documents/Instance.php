<?php

namespace Documents;

class Instance extends \Documents\Base
{
    static $collection = "instances";

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}'),
        'app'        => array('model' => 'Documents\App', 'type' => 'reference'),
        'cluster'    => array('model' => 'Documents\Cluster', 'type' => 'reference'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true),
    );

}
