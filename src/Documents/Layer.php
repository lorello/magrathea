<?php

// Document embedded in Clusters

namespace Documents;

class Layer extends \Documents\Base
{
    protected static $attrs = [
        'name'       => ['type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}', 'null' => false],
        //'nodes'      => array( 'type' => 'references', 'model' => 'Documents\Node'),
        'lastupdate' => ['type' => 'timestamp', 'autoupdate' => true],
    ];
}
