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
    protected $apiUrl;
//    protected $handler;
    protected $response;
//    protected $endPointUrlList;

    // Response And Status
    protected $responseStatus;
    protected $responseMessage;
    protected $responseError;
    protected $responseData;
    private $apiCredentials;

    // Access
    private $apiAccess;
    private $apiAccessPermission;
    private $apiAccessErrors;

    public function __construct()
    {
        $this->config = new ParseConfig();

        // Check is Api Available
        if (!$this->getApiStatus()) {
            die("Api Down!");
        }

        $this->setApiCredentials();
    }

    /**
     * @return bool
     */
    private function getApiStatus(): bool
    {
        $check = new ApiStatusCheck(
            $this->config->getApiUrl(),
            $this->config->getDevMode()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        $parseResponse = new ParseResponse($check->getResponse());
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

    private function setApiCredentials(): void
    {
        $apiCredentials = array_merge(
            $this->config->getApiKey(),
            $this->config->getApiSecret()
        );
        $this->apiCredentials = $apiCredentials;
    }

    /**
     * @return mixed
     */
    private function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    private function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @return mixed
     */
    private function getApiAccessPermission()
    {
        return $this->apiAccessPermission;
    }

    /**
     * @param mixed $apiAccessPermission
     */
    private function setApiAccessPermission($apiAccessPermission): void
    {
        $this->apiAccessPermission = $apiAccessPermission;
    }

    /**
     * @return mixed
     */
    private function getApiAccessErrors()
    {
        return $this->apiAccessErrors;
    }

    /**
     * @param mixed $apiAccessErrors
     */
    private function setApiAccessErrors($apiAccessErrors): void
    {
        $this->apiAccessErrors = $apiAccessErrors;
    }

    /**
     * @return bool
     */
    public function getAccessStatus(): bool
    {
        $check = new ApiAccessStatusCheck(
            $this->config->getApiUrl(),
            $this->config->getDevMode(),
            $this->getApiCredentials()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        $parseResponse = new ParseResponse($check->getResponse());

        $apiAccessData = $parseResponse->getResponseData();
        $this->setApiAccess($apiAccessData['api_access']);
        $this->setApiAccessErrors(null);
        if (isset($apiAccessData['errors'])) {
            $this->setApiAccessErrors($apiAccessData['errors']);
        }
        $this->setApiAccessPermission($apiAccessData['permission']);

        return $this->getApiAccess();
    }

    /**
     * @return array
     */
    private function getApiCredentials(): array
    {
        return $this->apiCredentials;
    }

    /**
     * @return array
     */
    protected function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * @return mixed
     */
    private function getApiAccess()
    {
        return $this->apiAccess;
    }

    /**
     * @param mixed $apiAccess
     */
    private function setApiAccess($apiAccess): void
    {
        $this->apiAccess = $apiAccess;
    }

    /**
     * @return string|null
     */
    public function getAccessError(): ?string
    {
        // if AccessStatus false; get key response->data->errors
    }

    /**
     * @return string
     */
    public function getAccessPermission(): ?string
    {
        // if AccessStatus true; get key -> response->data->permission
    }

    /**
     * @param array $logs
     * @param array $response
     */
    public function __invoke(array $logs, array $response)
    {
        if ($this->config->getDevMode()) {
            print_r($logs);
            print_r($response);
        }
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