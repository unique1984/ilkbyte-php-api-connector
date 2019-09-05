<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Helper;

use PhpApiConnector\Api\Api as Api;

final class ParseConfig extends Api
{
    protected $config;
    protected $devMode;
    protected $apiKey;
    protected $apiSecret;
    protected $sshKeys;
    protected $handler;
    protected $apiUrl;
    protected $endPointUrlList;

    public function __construct()
    {
        if (!is_file(__DIR__ . "/../.config")) {
            die(".config dosyası bulunamadı!");
        }

        require_once __DIR__ . "/../.config";

        /**
         * @var array $configParameters
         */
        if ($configParameters['devMode'] === true) {

            if (!is_file(__DIR__ . "/../.config.dev")) {
                copy(__DIR__ . "/../.config", __DIR__ . "/../.config.dev");
            }

            require_once __DIR__ . "/../.config.dev";
        }

//        var_dump($configParameters);
        $this->setConfig($configParameters);
        $this->setDevMode($configParameters['devMode']);
        $this->setApiKey($configParameters['apiKey']);
        $this->setApiSecret($configParameters['apiSecret']);
        $this->setSshKeys($configParameters['sshKeys']);
        $this->setHandler($configParameters['handler']);
        $this->setApiUrl($configParameters['apiUrl']);
        $this->setEndPointUrlList($configParameters['endPointUrlList']);
    }

    /**
     * @param mixed $config
     */
    private function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param mixed $apiKey
     */
    private function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param mixed $apiSecret
     */
    private function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    /**
     * @param mixed $sshKeys
     */
    private function setSshKeys($sshKeys)
    {
        $this->sshKeys = $sshKeys;
    }

    /**
     * @param mixed $handler
     */
    private function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param mixed $apiUrl
     */
    private function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param mixed $endPointUrlList
     */
    private function setEndPointUrlList($endPointUrlList)
    {
        $this->endPointUrlList = $endPointUrlList;
    }

    /**
     * @return bool
     */
    public function getDevMode()
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
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @return mixed
     */
    public function getSshKeys()
    {
        return $this->sshKeys;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return mixed
     */
    public function getEndPointUrlList()
    {
        return $this->endPointUrlList;
    }
}