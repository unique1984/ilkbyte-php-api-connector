<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Helper;

interface Errors
{
    const ERROR_API_DOWN = 'API Down!';
    const ERROR_API_KEY_WRONG = 'Api key or secret is wrong!';
    const ERROR_API_ERROR = 'Api Error: ';
    const ERROR_ACTIVE_SERVER_NONE = 'Active Server Not Found!';
    const ERROR_DNS_RECORD_TYPE_WRONG = "Wrong Record Type! limited [ 'A', 'AAAA', 'CNAME', 'MX', 'TXT', 'NS' ]";
}