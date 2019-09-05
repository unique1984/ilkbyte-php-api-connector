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
    public function __construct(string $url, array $parameters, bool $devMode)
    {
        $call = new Curl();
        $call->apiCall($url, $parameters, $devMode);
        $this->setLogs($call->logs);
        $this->setResponse($call->responseBody);
    }

    /**
     * @param mixed $logs
     */
    private function setLogs($logs): void
    {
        $this->logs = $logs;
    }

    /**
     * @param $response
     */
    private function setResponse($response): void
    {
        $this->response = $response;
    }
}