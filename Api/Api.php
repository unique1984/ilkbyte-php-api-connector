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
        }

        return $statusCheck->getResponse();
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