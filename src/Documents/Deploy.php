<?php

namespace Documents;

class Deploy extends \Documents\Base
{
    public static $collection = 'deploys';

    protected static $attrs = [
        'app'        => ['model' => 'Documents\App', 'type' => 'reference', 'null' => false],
        'owner'      => ['model' => 'Documents\User', 'type' => 'reference', 'null' => false],
        'instance'   => ['model' => 'Documents\Instance', 'type' => 'reference', 'null' => false],
        'lastupdate' => ['type' => 'timestamp', 'autoupdate' => true],
    ];
}
