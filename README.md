**Bu ApiConnector Kimin için?**
[ilkbyte](https://www.ilkbyte.com) müşteri hesabı bulunan ve sanal sunucuları için kendi otomasyonunu yazmak isteyen **geliştiriciler** için. 
---

**Ne yapar? - Ne yapmaz?**
* ilkbyte endpoint tarafına kendi [api dökümanlarında](https://github.com/ilkbyte/api.ilkbyte.com/wiki) belirtildiği şekilde istek yapar ve bool veya array türünde veri döndürür.
* Dönen veriyi işlemek **geliştirici** arkadaşın işidir ve bu repository bunu dert **edinmemektedir**.
---

**Temel Gereksinimler :**

1. PHP [7.2|7.3] test edildi. ([7.4] test edilecek.)
2. https://getcomposer.org/download/ adresinden işlemleri takip edin.
3. git
4. [ilkbyte](https://www.ilkbyte.com) müşteri hesabı (api bilgilerinin elde edileceği yer.)
5. Çalışır ve internet bağlantısı olan bir bilgisayar.
---



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
- createServer(...); // **API Geliştiriliyor**
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
- serverMonitor(string $serverName); // **API Geliştiriliyor**

- serverPowerJobs(string $serverName, string $job); // **API Geliştiriliyor** // [ start | shutdown | reboot | destroy ]
- addRdns(...); // **API Geliştiriliyor**
```php
addRdns(
        string $serverName,
        string $ip,
        string $rdns
    )
```
- serverIpLogs(string $serverName); // **API Geliştiriliyor**
- snapshotList(string $serverName); // **API Geliştiriliyor**
- snapshotRevert(string $serverName, int $snapShotId); // **API Geliştiriliyor**
- backupList(string $serverName); // **API Geliştiriliyor**
- backupRevert(string $serverName, int $snapShotId); // **API Geliştiriliyor**
- domainList(); // **API Geliştiriliyor**
- domainPush(string $domain); // **API Geliştiriliyor**
- domainAddDomain(string $domain, bool $pushIt); // **API Geliştiriliyor**
- domainShowDomain(string $domain); // **API Geliştiriliyor**
- domainAddRecord(...); // **API Geliştiriliyor**
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
- domainUpdateRecord(...); // **API Geliştiriliyor**
```php
domainUpdateRecord(
        string $domain,
        int $recordId,
        string $recordContent,
        int $recordPriority,
        bool $pushIt = false
    )
```
- domainDeleteDomain(string $domain); // **API Geliştiriliyor**
- accountInfo(); // **API Geliştiriliyor**
- accountPayment(); // **API Geliştiriliyor**