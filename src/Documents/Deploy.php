<?php

namespace Documents;

class Deploy extends \Documents\Base
{
    static $collection = 'deploys';

    protected static $attrs = array(
        'app'        => array('model' => 'Documents\App', 'type' => 'reference'),
        'owner'      => array('model' => 'Documents\User', 'type' => 'reference'),
        'instance'   => array('model' => 'Documents\Instance', 'type' => 'reference'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true)
    );

}
