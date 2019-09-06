<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\ApiConnector;

use PhpApiConnector\Handler\Curl;

final class ApiStatusCheck extends ApiConnector
{
    public function __construct(string $url, bool $devMode = false, array $parameters = array())
    {
        $call = new Curl();
        $call->apiCall($url, $devMode, $parameters);
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