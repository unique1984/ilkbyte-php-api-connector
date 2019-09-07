<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\ApiConnector;

use PhpApiConnector\Handler\Curl;

final class ApiDomainList extends ApiConnector
{
    public function __construct(array $parameters = array(), $devMode = false)
    {
        $call = new Curl();
        $url = self::URL_API . self::URL_DOMAIN_LIST;
        $call->apiCall($url, $devMode, $parameters);
        $this->setLogs($call->apiCallLogs);
        $this->setResponse($call->responseBody);
    }

    /**
     * @param mixed $logs
     */
    private function setLogs($logs): void
    {
        $this->apiCallLogs = $logs;
    }

    /**
     * @param $response
     */
    private function setResponse($response): void
    {
        $this->response = $response;
    }
}