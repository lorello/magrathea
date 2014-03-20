<?php

namespace Documents;

class Node extends \Documents\Base
{
    static $collection = 'nodes';

    const HOSTNAME_REGEXP = '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$';
    const FQDN_REGEXP     = '(?=^.{1,254}$)(^(?:(?!\d+\.)[a-zA-Z0-9_\-]{1,63}\.?)+(?:[a-zA-Z]{2,})$)';

    protected static $attrs = array(
        'name'       => array('type' => 'string', 'null' => false, 'regexp' => self::HOSTNAME_REGEXP),
        'fqdn'       => array('type' => 'string', 'null' => false, 'regexp' => self::FQDN_REGEXP),
        'cluster'    => array('type' => 'reference', 'model' => 'Documents\Cluster'),
        'owner'      => array('type' => 'reference', 'null' => false, 'model' => 'Documents\User'),
        'lastupdate' => array('type' => 'timestamp', 'autoupdate' => true)
    );

    public function initCollection()
    {
        self::ensure_index('name', array('unique' => true));
        self::ensure_index('fqdn', array('unique' => true));
    }
}