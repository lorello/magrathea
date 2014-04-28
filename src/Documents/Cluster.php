<?php

namespace Documents;

class Cluster extends \Documents\Base
{
    static $collection = "cluster";

    protected static $attrs = array(
        'name'   => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{2,}', 'null' => false),
        'layers' => array('type' => 'embeds', 'model' => 'Documents\Layer'),
        'layer' => array('type' => 'embed', 'model' => 'Documents\Layer'),
        'owner'  => array('type' => 'reference', 'model' => 'Documents\User', 'null' => false),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true)
    );
}
