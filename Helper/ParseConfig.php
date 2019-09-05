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
}