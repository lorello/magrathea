<?php

namespace Documents;

class Node extends \Purekid\Mongodm\Model
{
    static $collection = "nodes";

    protected static $attrs = array(
        'hostname'   => array('type' => 'string'),
        'fqdn'       => array('type' => 'string'),
        'lastupdate' => array('type' => 'timestamp')
    );

    function __preSave()
    {
        $date = new \DateTime();
        $this->__setter('lastupdate', $date->getTimestamp());

        return parent::__preSave();
    }
}