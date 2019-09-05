<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */
/*
 * vendor autoload dosyasını oluşturmak için composer.json dosyasının olduğu dizinde:
 * composer dump-autoload -o
 * komutunun verilmesi yeterlidir.
 * */
include 'vendor/autoload.php';

$a = new \PhpApiConnector\Api\Api();
var_dump($a);
