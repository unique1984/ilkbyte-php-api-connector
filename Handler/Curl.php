<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Handler;

class Curl
{
    public $logs = array();
    public $responseBody = array();

    public function apiCall(
        string $url,
        array $parameters = array(),
        bool $devMode = false
    ) {

        // IS DEBUG MODE ENABLED
        $sslVerify = true;
        if ($devMode) {
            $sslVerify = false;
        }

        // POST DATA INIT
        $postData = array_map('urlencode', $parameters);
        $postString = http_build_query($postData);

        // HEADERS INIT
        $headers = array(
            //~ "Content-Type: text/plain; charset=windows-1254",
            //~ "Content-Type: text/html; charset=ISO-8859-9",
//            "Content-Type: text/html; charset=UTF-8",
//            "Content-Type: multipart/form-data", // image post
            "Content-Type: application/x-www-form-urlencoded" // form post
        );

        // CURL INIT
        $ch = curl_init();

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, "Unique1984-PhpApiConnector " . VERSION . " - " . REPOSITORY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // SSL VERIFICATION
        if (!$sslVerify) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }

        // POST OPTIONS
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        // REDIRECTS
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        // RESPONSE HEADER
        curl_setopt($ch, CURLOPT_HEADER, 1);

        // EXECUTE REQUEST
        $returnData = curl_exec($ch);

        // GET ERRORS
        $this->logs['error'] = curl_error($ch);
        $chInfo = curl_getinfo($ch);
            $this->logs['info'] = $chInfo;

        // GET HEADER
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $this->logs['header'] = substr($returnData, 0, $header_size);

        // GET RESPONSE BODY
        $body = substr($returnData, $header_size);

        // CLOSE
        curl_close($ch);

        $this->responseBody = json_decode($body, true);
    }

    public function getBinary($url, $saveTo)
    {
        // https://stackoverflow.com/questions/6476212/save-image-from-url-with-curl-php?answertab=votes#tab-top
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        $raw = curl_exec($ch);
        curl_close($ch);

        if (file_exists($saveTo)) {
            //~ If exists incrementally save the data might be append.
            unlink($saveTo);
        }

        $fp = fopen($saveTo, 'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
}
