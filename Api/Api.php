<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Api;

use PhpApiConnector\Handler\ParseResponse;
use PhpApiConnector\Helper\Version;

class Api implements EndPointUrlList, Version
{
    // Curl->apiCall Logs [error, info, response_header]
    protected $logs;

    // Config
    protected $devMode;
    protected $apiKey;
    protected $apiSecret;
    protected $sshKeys;
    private $apiCredentials;

    // Response And Status
    protected $response;
    protected $responseStatus;
    protected $responseMessage;
    protected $responseError;
    protected $responseData;

    // Access
    private $apiAccess;
    private $apiAccessPermission;
    private $apiAccessErrors;

    public function __construct(
        string $apiKey,
        string $apiSecret,
        string $sshPublicKeys,
        bool $devMode = false
    )
    {
        $this->setApiCredentials($apiKey, $apiSecret);
        $this->setDevMode($devMode);

        // Check is Api Available
        if (!$this->getApiStatus()) {
            die("Api Down!");
        }
    }

    /**
     * @return bool
     */
    private function getApiStatus(): bool
    {
        $check = new ApiStatusCheck(
            self::URL_API,
            $this->getDevMode()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        $parseResponse = new ParseResponse($check->getResponse());
        return $parseResponse->getResponseStatus();
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

    private function setApiCredentials($apiKey, $apiSecret): void
    {
        $apiCredentials = array(
            'access' => $apiKey,
            'secret' => $apiSecret
        );
        $this->apiCredentials = $apiCredentials;
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
            self::URL_API,
            $this->getDevMode(),
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
     * @param null|array $logs
     * @param null|array $response
     */
    public function __invoke($logs, $response)
    {
        if ($this->getDevMode() && !is_null($logs) || !is_null($response)) {
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
     * @return mixed
     */
    protected function getSshKeys()
    {
        return $this->sshKeys;
    }

}