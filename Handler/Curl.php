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
    public function getPage($url, $method = 'post', $parameters = array(), $debug = false, $sslVerify = false)
    {
        $headers = array(
            //~ "Content-Type: text/plain; charset=windows-1254",
            //~ "Content-Type: text/html; charset=ISO-8859-9",
            "Content-Type: text/html; charset=UTF-8",
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT,
            "Ysn-PhpApiConnector " . VERSION);
        if (!$verify) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //~ curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $returnData = curl_exec($ch);
        $chInfo = curl_getinfo($ch);
        $debug ? print_r($chInfo) : null;
        curl_close($ch);
        //~ $returnData=json_encode($returnData);
        //~ $returnData=json_decode($returnData);
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
            //~ Varsa numaralandır eklenebilir...
            unlink($saveTo);
        }

        $fp = fopen($saveTo, 'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
}
