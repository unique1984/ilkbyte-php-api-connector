<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\ApiConnector;

use PhpApiConnector\Handler\ParseResponse;
use PhpApiConnector\Helper\Errors;
use PhpApiConnector\Helper\Version;

class ApiConnector implements EndPointUrlList, Version, Errors
{
    protected $devMode;
    protected $apiCallLogs;
    protected $sshKeys;
    protected $response;
    protected $responseStatus;
    protected $responseMessage;
    protected $responseError;
    protected $responseData;
    private $apiCredentials;

    public function __construct(
        string $apiKey,
        string $apiSecret,
        string $sshPublicKeys = null,
        bool $devMode = false
    ) {
        $this->setDevMode($devMode);
        $this->setApiCredentials($apiKey, $apiSecret);
        $this->setSshKeys($sshPublicKeys);
    }

    private function setApiCredentials($apiKey, $apiSecret): void
    {
        $apiCredentials = array(
            'access' => $apiKey,
            'secret' => $apiSecret
        );
        $this->apiCredentials = $apiCredentials;
    }

    private function checkApiStatus($status, $error)
    {
        if (!$status) {
            die(self::ERROR_API_DOWN);
        }

        if (!is_null($error)) {
            die(self::ERROR_API_ERROR . $this->getResponseError());
        }
    }

    public function checkApiAccess()
    {
        $check = new ApiAccessCheck(
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        $parseResponse = new ParseResponse($check->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    /**
     * @return array
     */
    private function getApiCredentials(): array
    {
        return $this->apiCredentials;
    }

    /**
     * @return mixed
     */
    public function getDevMode()
    {
        return $this->devMode;
    }

    /**
     * @param mixed $devMode
     */
    public function setDevMode($devMode): void
    {
        $this->devMode = $devMode;
    }

    /**
     * @return mixed
     */
    protected function getLogs()
    {
        return $this->apiCallLogs;
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
    public function getResponseStatus()
    {
        return $this->responseStatus;
    }

    /**
     * @return mixed
     */
    public function getResponseError()
    {
        return $this->responseError;
    }

    /**
     * @return mixed
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @return mixed
     */
    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * @param null|array $logs
     * @param null|array $response
     */
    public function __invoke($logs, $response)
    {
        if ($this->getDevMode() && (!is_null($logs) || !is_null($response))) {
            print_r($logs);
            print_r($response);
        }
    }

    /**
     * @return array
     */
    protected function getSshKeys(): array
    {
        return $this->sshKeys;
    }

    /**
     * @param mixed $sshKeys
     */
    protected function setSshKeys($sshKeys): void
    {
        $this->sshKeys = array(
            'sshkey' => $sshKeys
        );
    }

}