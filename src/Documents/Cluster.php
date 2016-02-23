<?php

namespace Documents;

class Cluster extends \Documents\Base
{
    public static $collection = 'cluster';

    protected static $attrs = [
        'name'       => ['type' => 'string', 'regexp' => '[a-z][a-z0-9]{2,}', 'null' => false],
        'layers'     => ['type' => 'embeds', 'model' => 'Documents\Layer'],
        'layer'      => ['type' => 'embed', 'model' => 'Documents\Layer'],
        'owner'      => ['type' => 'reference', 'model' => 'Documents\User', 'null' => false],
        'lastupdate' => ['type' => 'timestamp', 'autoupdate' => true],
    ];
}
