`git clone https://github.com/unique1984/ilkbyte-php-api-connector.git`

Clon işleminden sonra **native php** için;

Composer `vendor/autoload` dosyası oluşturmak için, composer.json dosyasının olduğu dizinde: 
```
composer dump-autoload -o
```
komutunun verilmesi yeterli.

`Examples/_inc.php` dosyasının içeriği.
```php
<?php
...
$apiKey = '<API KEY>';
$apiSecret = '<API SECRET>';
$sshPublicKeys = '<PUBLIC SSH KEYS>'; // virgülle ayrılmış

include 'vendor/autoload.php'; // PSR-4 autoloader yükle.
```

Methodlar: (Açıklama ve kullanım örnekleri ve açıklamaları eklenecek!)
- checkApiAccess();
- activeServers();
- allServers();
- deletedServers();
- canceledServers();
- serverReadyApplications();
- serverOperatingSystems();
- serverPackages();
- createServer(...);  
```php
    createServer(
          string $username,
          string $password,
          string $serverName,
          int $osId,
          int $appId,
          int $packageId,
          bool $sshKeys = true
      );
```

- serverStatus(string $serverName);
- serverMonitor(string $serverName);
- serverPowerJobs(string $serverName, string $job);
- addRdns(...);
```php
addRdns(
        string $serverName,
        string $ip,
        string $rdns
    )
```
- serverIpLogs(string $serverName);
- snapshotList(string $serverName);
- snapshotRevert(string $serverName, int $snapShotId);
- backupList(string $serverName);
- backupRevert(string $serverName, int $snapShotId);
- domainList();
- domainPush(string $domain);
- domainAddDomain(string $domain, bool $pushIt);
- domainShowDomain(string $domain);
- domainAddRecord(...);
```php
domainAddRecord(
        string $domain,
        string $recordName,
        string $recordType,
        string $recordContent,
        int $recordPriority,
        bool $pushIt = false
    )
```
- domainUpdateRecord(...);
```php
domainUpdateRecord(
        string $domain,
        int $recordId,
        string $recordContent,
        int $recordPriority,
        bool $pushIt = false
    )
```
- domainDeleteDomain(string $domain);
- accountInfo();
- accountPayment();