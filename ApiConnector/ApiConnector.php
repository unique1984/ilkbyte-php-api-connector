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
    // Curl->apiCall Logs [error, info, response_header]
    public $devMode;
    protected $logs;
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
        $this->setApiCredentials($apiKey, $apiSecret);
//        $this->setDevMode($devMode);
        $this->devMode = $devMode;
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

    public function checkApiAccess()
    {
        $check = new ApiAccessCheck(
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
     * @return array
     */
    public function getSshKeys(): array
    {
        return $this->sshKeys;
    }

    /**
     * @param mixed $sshKeys
     */
    public function setSshKeys($sshKeys): void
    {
        $this->sshKeys = array(
            'sshkey' => $sshKeys
        );
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

}