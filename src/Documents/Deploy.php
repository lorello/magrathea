<?php

namespace Documents;

class Deploy extends \Documents\Base
{
    static $collection = 'deploys';

    protected static $attrs = array(
        'app'        => array('model' => 'Documents\App', 'type' => 'reference', 'null' => false),
        'owner'      => array('model' => 'Documents\User', 'type' => 'reference', 'null' => false),
        'instance'   => array('model' => 'Documents\Instance', 'type' => 'reference', 'null' => false),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true)
    );

}
