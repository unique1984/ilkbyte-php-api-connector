<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\ApiConnector;

use PhpApiConnector\Handler\Curl;

final class ApiAccessCheck extends ApiConnector
{
    public function __construct(array $parameters = array())
    {
//        var_dump($this->getDevMode());
        var_dump($this->devMode);
        var_dump(self::URL_API);
        print_r($parameters);

        die;

        $call = new Curl();
        $call->apiCall(self::URL_API, $devMode, $parameters);
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