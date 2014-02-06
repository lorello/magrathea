<?php

namespace Documents;

class Cluster extends \Purekid\Mongodm\Model
{
    static $collection = "cluster";

    protected static $attrs = array(
        'name'       => array('type' => 'string'),
        'layers'     => array('model' => 'Documents\Node', 'type' => 'embeds'),
        'lastupdate' => array('type' => 'timestamp')
    );

    function __preSave()
    {
        $date = new \DateTime();
        $this->__setter('lastupdate', $date->getTimestamp());

        return parent::__preSave();
    }
}
