<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Api;

use PhpApiConnector\Helper\ParseConfig;

class Api
{
    public function __construct()
    {
        $config = new ParseConfig();
        print_r($config->getHandler());
    }

}