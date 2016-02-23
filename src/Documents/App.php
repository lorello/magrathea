<?php

namespace Documents;

class App extends \Documents\Base
{
    public static $collection = 'apps';

    protected static $attrs = [
        'name'       => ['type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}', 'null' => false],
        'owner'      => ['type' => 'reference', 'null' => false, 'model' => 'Documents\User'],
        // users owns apps
        'users'      => ['type' => 'references', 'model' => 'Documents\User'],
        // other authorized users of this apps
        'lastupdate' => ['type' => 'timestamp', 'autoupdate' => true],
        'conf'       => ['type' => 'string', 'null' => false],
        // place to store magrathea.yml
    ];
}
