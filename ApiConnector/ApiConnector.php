<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\ApiConnector;

use PhpApiConnector\Helper\ParseResponse;
use PhpApiConnector\Helper\EndPointUrlList;
use PhpApiConnector\Helper\StaticValues;
use PhpApiConnector\Helper\Version;
use PhpApiConnector\Helper\Errors;

class ApiConnector implements EndPointUrlList, StaticValues, Version, Errors
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
    protected function getDevMode()
    {
        return $this->devMode;
    }

    /**
     * @param mixed $devMode
     */
    protected function setDevMode($devMode): void
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

    private function checkApiStatus($status, $error)
    {
        if (!$status) {
            die(self::ERROR_API_DOWN);
        }

        if (!is_null($error)) {
            die(self::ERROR_API_ERROR . $this->getResponseError());
        }
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
    protected function getResponseStatus()
    {
        return $this->responseStatus;
    }

    /**
     * @return mixed
     */
    protected function getResponseData()
    {
        return $this->responseData;
    }

    public function canceledServers()
    {
        $check = new ApiAccessCheck(
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        $allServers = $this->allServers();

        $canceledServers = array();
        foreach ($allServers as $item => $servers) {
            if (!preg_match('/\w+REMOVE\d{1,}/', $servers['name']) && $servers['service'] == 'cancel') {
                $canceledServers[] = $allServers[$item];
            }
        }

        return $canceledServers;
    }

    public function allServers()
    {
        $check = new ApiAllServerList(
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

        $response = $parseResponse->getResponseData();

        $pagination = $response['pagination'];
        $server_list = $response['server_list'];

        return $server_list;
    }

    public function activeServers()
    {
        $check = new ApiActiveServerList(
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

        $response = $parseResponse->getResponseData();

        $pagination = $response['pagination'];
        $server_list = $response['server_list'];

        return $server_list;
    }

    public function snapshotList(string $serverName)
    {
        $check = new ApiSnapshotList(
            $serverName,
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

    public function snapshotRevert(string $serverName, int $snapShotId)
    {
        $parameters = [
            'snapshot_id' => $snapShotId,
        ];

        $postData = array_merge(
            $this->getApiCredentials(),
            $parameters
        );

        $revert = new ApiSnapshotRevert(
            $serverName,
            $postData,
            $this->getDevMode()
        );

        $this(
            $revert->getLogs(),
            $revert->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($revert->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function backupList(string $serverName)
    {
        $check = new ApiBackupList(
            $serverName,
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

    public function backupRevert(string $serverName, int $backupId)
    {
        $parameters = [
            'backup_id' => $backupId,
        ];

        $postData = array_merge(
            $this->getApiCredentials(),
            $parameters
        );

        $revert = new ApiBackupRevert(
            $serverName,
            $postData,
            $this->getDevMode()
        );

        $this(
            $revert->getLogs(),
            $revert->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($revert->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function deletedServers()
    {
        $check = new ApiAccessCheck(
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        $allServers = $this->allServers();

        $deleted = array();
        foreach ($allServers as $item => $servers) {
            if (preg_match('/\w+REMOVE\d{1,}/', $servers['name']) && $servers['service'] == 'cancel') {
                $deleted[] = $allServers[$item];
            }
        }

        return $deleted;
    }

    public function createServer(
        string $username,
        string $password,
        string $serverName,
        int $osId,
        int $appId,
        int $packageId,
        bool $sshKeys = true
    ) {
        // ön kontrol mekanizması eklenebilir, (os_id > 0 ? app_id = 0) (server name mevcut, paket yok gibi)
        $parameters = [
            'username' => $username,
            'password' => $password,
            'name' => $serverName,
            'os_id' => $osId,
            'appId' => $appId,
            'package_id' => $packageId
        ];

        $postData = array_merge(
            $this->getApiCredentials(),
            $parameters
        );

        if ($sshKeys) {
            $postData = array_merge($postData, $this->getSshKeys());
        }

        $create = new ApiCreateServer(
            $postData,
            $this->getDevMode()
        );

        $this(
            $create->getLogs(),
            $create->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($create->getResponse());
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

    public function addRdns(
        string $serverName,
        string $ip,
        string $rdns
    ) {
        $parameters = [
            'ip' => $ip,
            'rdns' => $rdns
        ];

        $postData = array_merge(
            $this->getApiCredentials(),
            $parameters
        );

        $add = new ApiAddRdns(
            $serverName,
            $postData,
            $this->getDevMode()
        );

        $this(
            $add->getLogs(),
            $add->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($create->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function serverStatus(string $serverName)
    {
        $check = new ApiServerStatus(
            $serverName,
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

    public function serverIpLogs(string $serverName)
    {
        $logs = new ApiServerIpLogs(
            $serverName,
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $logs->getLogs(),
            $logs->getResponse()
        );

        $parseResponse = new ParseResponse($logs->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function serverMonitor(string $serverName)
    {
        $check = new ApiServerMonitor(
            $serverName,
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

    public function serverPowerJobs(string $serverName, string $job)
    {
        $parameters = array_merge(
            $this->getApiCredentials(),
            ['set' => $job]
        );

        $check = new ApiServerPowerJobs(
            $serverName,
            $parameters,
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

    public function serverReadyApplications()
    {
        $check = new ApiServerReadyApplications(
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

        $data = $parseResponse->getResponseData();
        return $data['application'];
    }

    public function serverOperatingSystems()
    {
        $check = new ApiServerOperatingSystems(
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

        $data = $parseResponse->getResponseData();
        return $data['operating_system'];
    }

    public function serverPackages()
    {
        $check = new ApiServerOperatingSystems(
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

        $data = $parseResponse->getResponseData();
        return $data['package'];
    }

    public function domainList()
    {
        $check = new ApiDomainList(
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

    public function domainAddDomain(string $domain, bool $pushIt)
    {
        $parameters = array_merge(
            $this->getApiCredentials(),
            [
                'domain' => $domain
            ]
        );

        $add = new ApiDomainAddDomain(
            $parameters,
            $this->getDevMode()
        );

        $this(
            $add->getLogs(),
            $add->getResponse()
        );

        if ($pushIt) {
            $this->domainPush($domain);
        }

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($add->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function domainPush(string $domain)
    {
        $push = new ApiDomainPush(
            $domain,
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $push->getLogs(),
            $push->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($push->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function domainShowDomain(string $domain)
    {
        $show = new ApiDomainShow(
            $domain,
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $show->getLogs(),
            $show->getResponse()
        );

        $parseResponse = new ParseResponse($show->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function domainDeleteDomain(string $domain)
    {
        $show = new ApiDomainDelete(
            $domain,
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $show->getLogs(),
            $show->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($show->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function domainAddRecord(
        string $domain,
        string $recordName,
        string $recordType,
        string $recordContent,
        int $recordPriority,
        bool $pushIt = false
    ) {
        $recordType = strtoupper($recordType);
        if (!in_array($recordType, self::VALUE_DNS_RECORD_TYPES)) {
            die(self::ERROR_DNS_RECORD_TYPE_WRONG);
        }

        $parameters = array_merge(
            $this->getApiCredentials(),
            [
                'record_name' => $recordName,
                'record_type' => $recordType,
                'record_content' => $recordContent,
                'record_priority' => $recordPriority,
            ]
        );

        $add = new ApiDomainAddRecord(
            $domain,
            $parameters,
            $this->getDevMode()
        );

        $this(
            $add->getLogs(),
            $add->getResponse()
        );

        if ($pushIt) {
            $this->domainPush($domain);
        }

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($add->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function domainUpdateRecord(
        string $domain,
        int $recordId,
        string $recordContent,
        int $recordPriority,
        bool $pushIt = false
    ) {
        $parameters = array_merge(
            $this->getApiCredentials(),
            [
                'record_id' => $recordId,
                'record_content' => $recordContent,
                'record_priority' => $recordPriority,
            ]
        );

        $update = new ApiDomainUpdateRecord(
            $domain,
            $parameters,
            $this->getDevMode()
        );

        $this(
            $update->getLogs(),
            $update->getResponse()
        );

        if ($pushIt) {
            $this->domainPush($domain);
        }

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($update->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
    }

    public function accountInfo()
    {
        $check = new ApiAccountInfo(
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

    public function accountPayment()
    {
        $check = new ApiAccountPayment(
            $this->getApiCredentials(),
            $this->getDevMode()
        );

        $this(
            $check->getLogs(),
            $check->getResponse()
        );

        die("Gerisi Api faaliyete geçince...");
        $parseResponse = new ParseResponse($check->getResponse());
        $this->checkApiStatus(
            $parseResponse->getResponseStatus(),
            $parseResponse->getResponseError()
        );

        // $parseResponse->getResponseMessage();

        return $parseResponse->getResponseData();
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
     * @return mixed
     */
    protected function getResponseMessage()
    {
        return $this->responseMessage;
    }

}