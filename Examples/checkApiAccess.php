<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

// $apiKey, $apiSecret, $sshPublicKeys & autoloading
require_once '_inc.php';

// create instance
$connector = new \PhpApiConnector\ApiConnector\ApiConnector
(
    $apiKey,
    $apiSecret,
    $sshPublicKeys,
    false
);

var_dump($connector->checkApiAccess());
