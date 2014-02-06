<?php

namespace Documents;

class Base extends \Purekid\Mongodm\Model
{

    function __preSave()
    {
        foreach (self::$attrs as $key => $attr) {

            // Manage field attribute NOT NULL
            if (isset($attr['null']) and ($attr['null'] === false)) {
                if (!isset($this->cleanData[$key]) or empty($this->cleanData[$key])) {
                    throw new \Exception("The field '$key' cannot be empty");
                }
            }

            // Manage filed attribute 'autoupdate'
            if ($attr['type'] == self::DATA_TYPE_TIMESTAMP and isset($attr['autoupdate']) and ($attr['autoupdate'] === true)) {
                $date                  = new \DateTime();
                $this->cleanData[$key] = $date->getTimestamp();
            }
        }

        return parent::__preSave();
    }
}