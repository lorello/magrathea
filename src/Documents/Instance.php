<?php

namespace Documents;

class Instance extends \Documents\Base
{
    public static $collection = 'instances';

    protected static $attrs = [
        'name'       => ['type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}', 'null' => false],
        'app'        => ['model' => 'Documents\App', 'type' => 'reference'],
        'cluster'    => ['model' => 'Documents\Cluster', 'type' => 'reference', 'null' => false],
        'lastupdate' => ['type' => 'timestamp', 'autoupdate' => true],
    ];
}
