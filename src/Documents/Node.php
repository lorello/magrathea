<?php

namespace Documents;

class Node extends \Documents\Base
{
    static $collection = "nodes";

    protected static $attrs = array(
        'hostname'   => array('type' => 'string', 'null' => false),
        'fqdn'       => array('type' => 'string'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true)
    );
    /*
        function __preSave()
        {
            // Implemented in Document\Base
            // $date = new \DateTime();
            // $this->__setter('lastupdate', $date->getTimestamp());

            // Implemented in Document\Base
    //        foreach(self::$attrs as $key=>$attr){
    //            if (isset($attr['null']) and ($attr['null']===FALSE)) {
    //                if (!isset($this->cleanData[$key]) or empty($this->cleanData[$key])) {
    //                    throw new \Exception("The field '$key' cannot be empty");
    //                }
    //            }
    //        }

            return parent::__preSave();
        }
    */
}