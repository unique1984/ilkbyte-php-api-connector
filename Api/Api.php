<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Api;

use PhpApiConnector\Handler\ParseResponse;
use PhpApiConnector\Helper\ParseConfig;

class Api
{
    // Curl->apiCall Logs [error, info, header]
    protected $logs;

    // Config
    protected $config;
    protected $devMode;
    protected $apiKey;
    protected $apiSecret;
    protected $sshKeys;
    protected $handler;
    protected $apiUrl;
    protected $endPointUrlList;

    // Response
    protected $response;
    protected $responseStatus;
    protected $responseMessage;
    protected $responseError;
    protected $responseData = array();

    public function __construct()
    {
        $this->config = new ParseConfig();
    }

    public function getStatus()
    {
        // @TODO UrlBuilder ile url kontrolü ve oluşturulması eklenecek.

        $statusCheck = new StatusCheck(
            $this->config->getApiUrl(),
            array_merge(
                $this->config->getApiKey(),
                $this->config->getApiSecret()
            ),
            $this->config->getDevMode()
        );

        // @TODO Ayrıca bir method içerisine alınacak...
        if ($this->config->getDevMode()) {
            print_r($statusCheck->getLogs());
            print_r($statusCheck->getResponse());
        }

        $parseResponse = new ParseResponse($statusCheck->getResponse());
        return $parseResponse->getResponseStatus();
    }

    /**
     * @return mixed
     */
    protected function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return mixed
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    protected function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @return bool
     */
    protected function getDevMode()
    {
        return $this->devMode;
    }

    /**
     * @param mixed $devMode
     */
    protected function setDevMode($devMode)
    {
        $this->devMode = $devMode;
    }

    /**
     * @return mixed
     */
    protected function getLogs()
    {
        return $this->logs;
    }

    /**
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    protected function getResponseStatus()
    {
        return $this->responseStatus;
    }

    /**
     * @return mixed
     */
    protected function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * @return mixed
     */
    protected function getResponseError()
    {
        return $this->responseError;
    }

    /**
     * @return array
     */
    protected function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * @return ParseConfig
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @return mixed
     */
    protected function getSshKeys()
    {
        return $this->sshKeys;
    }

    /**
     * @return mixed
     */
    protected function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return mixed
     */
    protected function getEndPointUrlList()
    {
        return $this->endPointUrlList;
    }
}