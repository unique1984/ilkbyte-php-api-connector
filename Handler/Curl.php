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
    public function apiCall(
        string $url,
        array $parameters = array(),
        bool $devMode = false
    ) {

        // IS DEBUG MODE ENABLED
        $debug = false;
        $sslVerify = true;
        if ($devMode) {
            $debug = true;
            $sslVerify = false;
        }

        // POST DATA INIT
        $postData = array_map('urlencode', $parameters);
        $postString = http_build_query($postData);

        $headers = array(
            //~ "Content-Type: text/plain; charset=windows-1254",
            //~ "Content-Type: text/html; charset=ISO-8859-9",
//            "Content-Type: text/html; charset=UTF-8",
//            "Content-Type: multipart/form-data", // image post
            "Content-Type: application/x-www-form-urlencoded" // form post
        );

        $ch = curl_init();

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

        // POST
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, count($postData));
//        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if ($debug) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        // EXECUTE REQUEST
        $returnData = curl_exec($ch);

        if (curl_errno($ch)) {
            die("Curl Error: " . curl_error($ch));
        }

        $chInfo = curl_getinfo($ch);
        if ($debug) {
            print_r($chInfo);
        }
        curl_close($ch);

        return $returnData;
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
