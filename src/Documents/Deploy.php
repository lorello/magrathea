<?php

namespace Documents;

class Deploy extends \Purekid\Mongodm\Model
{
    static $collection = 'deploys';

    protected static $attrs = array(
        'app'        => array('model' => 'Documents\App', 'type' => 'reference'),
        'instance'   => array('model' => 'Documents\Instance', 'type' => 'reference'),
        'lastupdate' => array('type' => 'timestamp')

    );

    function __preSave()
    {
        $date = new \DateTime();
        $this->__setter('lastupdate', $date->getTimestamp());

        return parent::__preSave();
    }
}
