<?php

namespace Documents;

class Base extends \Purekid\Mongodm\Model
{
    // Add ODM properties
    protected function __preSave()
    {
        $attrs = self::getAttrs();

        foreach ($attrs as $key => $attr) {

            $value = $this->__get($key);

            // Manage field attribute NOT NULL
            if (isset($attr['null']) and ($attr['null'] === false)) {
                if (!$this->__isset($key) or empty($value)) {
                    throw new \Exception("The field '$key' cannot be empty");
                }
            }

            // Manage field attribute 'autoupdate'
            if ((isset($attr['type']) and $attr['type'] == self::DATA_TYPE_TIMESTAMP) and
                isset($attr['autoupdate']) and ($attr['autoupdate'] === true)
            ) {
                $date = new \DateTime();
                $ts   = $date->getTimestamp();
                $this->__set($key, $ts);
            }

            // Manage field attribute 'regexp'
            if ((isset($attr['type']) and $attr['type'] == self::DATA_TYPE_STRING) and isset($attr['regexp'])) {
                $filter_options = array('options' => array('regexp' => '/' . $attr['regexp'] . '/'));
                if (!filter_var($value, FILTER_VALIDATE_REGEXP, $filter_options)) {
                    throw new \Exception("The field '$key' doesn't validate against expression '$attr[regexp]'");
                }
            }
        }

        return parent::__preSave();
    }

}