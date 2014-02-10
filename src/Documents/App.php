<?php

namespace Documents;

class App extends \Documents\Base
{
    static $collection = "apps";

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'regexp' => '[a-z][a-z0-9]{4,}'),
        'owner'      => array('type' => 'reference'), // users owns apps
        'users'      => array('type' => 'references'), // other authorized users of this apps
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true),
        'conf'       => array('type' => 'string'), // place to store magrathea.yml
    );
}
