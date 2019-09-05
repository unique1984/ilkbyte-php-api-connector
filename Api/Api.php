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
//        echo http_build_query(array_merge($config->getApiKey(), $config->getApiSecret())) . "\n";
//        $status = new StatusCheck("http://localhost/services", array(), $config->getDevMode());
        $status = new StatusCheck(
            $config->getApiUrl(),
            array_merge(
                $config->getApiKey(),
                $config->getApiSecret()
            ),
            $config->getDevMode()
        );

        print_r(json_decode(json_encode($status->getStatus()), 1));

//        var_dump($status->getStatus());
    }

}