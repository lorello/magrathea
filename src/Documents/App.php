<?php

namespace Documents;

class App extends \Purekid\Mongodm\Model
{
    static $collection = "apps";

    protected static $attrs = array(
        'name'       => array('type' => 'string'),
        'owner'      => array('type' => 'reference'),
        'users'      => array('type' => 'references'),
        'lastupdate' => array('type' => 'timestamp'),
        'conf'       => array('type' => 'string'),
    );

    function __preSave()
    {
        $date = new \DateTime();
        $this->__setter('lastupdate', $date->getTimestamp());

        return parent::__preSave();
    }
}
