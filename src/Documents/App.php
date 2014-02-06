<?php

namespace Documents;

class App extends \Documents\Base
{
    static $collection = "apps";

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}'),
        'owner'      => array('type' => 'reference'),
        'users'      => array('type' => 'references'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true),
        'conf'       => array('type' => 'string'),
    );
}
