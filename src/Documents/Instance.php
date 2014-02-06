<?php

namespace Documents;

class Instance extends \Purekid\Mongodm\Model
{
    static $collection = "instances";

    protected static $attrs = array(
        'id'         => array('type' => 'string'),
        'app'        => array('model' => 'Documents\App', 'type' => 'reference'),
        'cluster'    => array('model' => 'Documents\Cluster', 'type' => 'reference'),
        'lastupdate' => array('type' => 'timestamp'),
    );

    function __preSave()
    {
        $date = new \DateTime();
        $this->__setter('lastupdate', $date->getTimestamp());

        return parent::__preSave();
    }
}
