<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Handler;

use PhpApiConnector\Api\Api;

class ParseResponse extends Api
{
    public function __construct($response)
    {
        // @TODO Doğrulama yapılacak, şimdilik değerler atanıyor
        $this->setResponseStatus($response['status']);
        $this->setResponseMessage($response['message']);
        $this->setResponseError($response['error']);
        $this->setResponseData($response['data']);
    }

    /**
     * @param mixed $responseStatus
     */
    private function setResponseStatus($responseStatus): void
    {
        $this->responseStatus = $responseStatus;
    }

    /**
     * @param mixed $responseMessage
     */
    private function setResponseMessage($responseMessage): void
    {
        $this->responseMessage = $responseMessage;
    }

    /**
     * @param mixed $responseError
     */
    private function setResponseError($responseError): void
    {
        $this->responseError = $responseError;
    }

    /**
     * @param mixed $responseData
     */
    private function setResponseData($responseData): void
    {
        $this->responseData = $responseData;
    }
}