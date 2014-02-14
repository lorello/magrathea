<?php

namespace Documents;

class App extends \Documents\Base
{
    static $collection = "apps";

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}', 'null' => false),
        'owner'      => array('type' => 'reference', 'null' => false, 'model' => 'Documents\User'),
        // users owns apps
        'users'      => array('type' => 'references', 'model' => 'Documents\User'),
        // other authorized users of this apps
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true),
        'conf'       => array('type' => 'string', 'null' => false),
        // place to store magrathea.yml
    );
}
