<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Api;

use PhpApiConnector\Handler\Curl;

final class StatusCheck extends Api
{
    private $status;

    public function __construct($url, $parameters, $devMode)
    {
        $call = new Curl();
        $status = $call->apiCall($url, $parameters, $devMode);

        print_r($status);

        $this->setStatus($status);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    private function setStatus($status): void
    {
        $this->status = $status;
    }

}