<?php

# Document embedded in Clusters

namespace Documents;

class Layer extends \Documents\Base
{

    #static $collection = "layer";

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}', 'null' => false),
        #'nodes'      => array( 'type' => 'references', 'model' => 'Documents\Node'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true),
    );
}