<?php
/**
 * © Copyright 2019
 * Yasin KARABULAK <info@yasinkarabulak.com>
 * MIT License
 * http://ozgurlisanslar.org.tr/mit/
 */

namespace PhpApiConnector\Helper;

interface EndPointUrlList
{
    const URL_API = 'https://api.ilkbyte.com';
    const URL_SERVER_LIST = '/server/list';
    const URL_SERVER_LIST_ALL = '/server/list/all';
    const URL_SERVER_CREATE = '/server/create';
//    const URL_SERVER_CREATE_CONFIG = '/server/create/config';
    const URL_SERVER_CREATE_CONFIG = 'http://services/api'; // FAKE EndPoint Test Purposes
    /* %s -> server name */
    const URL_SERVER_STATUS = '/server/manage/%s/show';
    const URL_SERVER_MONITOR = '/server/manage/%s/monitor';
    const URL_POWER = '/server/manage/%s/power';
//    const URL_IP_RDNS = '/server/manage/%s/ip/rdns';
    const URL_IP_RDNS = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
    const URL_LOGS = '/server/manage/%s/ip/logs';
    const URL_SNAPSHOT_LIST = '/server/manage/%s/snapshot/list';
//    const URL_SNAPSHOT_REVERT = '/server/manage/%s/snapshot/revert';
    const URL_SNAPSHOT_REVERT = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
    const URL_BACKUP_LIST = '/server/manage/%s/backup/list';
//    const URL_BACKUP_REVERT = '/server/manage/%s/backup/revert';
    const URL_BACKUP_REVERT = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
    /* %s -> domain name */
    const URL_DOMAIN_LIST = '/domain/list';
//    const URL_DOMAIN_PUSH = '/domain/manage/%s/push';
    const URL_DOMAIN_PUSH = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
//    const URL_DOMAIN_CREATE = '/domain/create';
    const URL_DOMAIN_CREATE = 'http://services/api'; // FAKE EndPoint Test Purposes
    const URL_DOMAIN_SHOW = '/domain/manage/%s/show';
//    const URL_DOMAIN_ADD_RECORD = '/domain/manage/%s/add';
    const URL_DOMAIN_ADD_RECORD = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
//    const URL_DOMAIN_UPDATE = '/domain/manage/%s/update';
    const URL_DOMAIN_UPDATE = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
//    const URL_DOMAIN_DELETE = '/domain/manage/%s/delete';
    const URL_DOMAIN_DELETE = 'http://services/api/%s'; // FAKE EndPoint Test Purposes
    const URL_ACCOUNT = '/account';
//    const URL_ACCOUNT_PAYMENT = '/account/payment';    // Developing
    const URL_ACCOUNT_PAYMENT = 'http://services/api'; // FAKE EndPoint Test Purposes
}