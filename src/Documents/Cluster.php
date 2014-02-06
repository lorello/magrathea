<?php

namespace Documents;

class Cluster extends \Documents\Base
{
    static $collection = "cluster";

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{2,}'),
        'layers'     => array('model' => 'Documents\Node', 'type' => 'embeds'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true)
    );

}
