**Bu ApiConnector Kimin için?**

* [ilkbyte](https://www.ilkbyte.com) müşteri hesabı bulunan ve sanal sunucuları için kendi otomasyonunu yazmak isteyen **geliştiriciler** için. 

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
5. Çalışır durumda ve internet bağlantısı olan bir bilgisayar.

---

**Kurulum & Kullanım :**

**composer**

Paket [packagist](https://packagist.org/packages/unique1984/ilkbyte-php-api-connector) deposuna yüklü ve github entegreli olduğundan `commposer require` komutu ile gerekli kurulumu yapmış olursunuz.)

`composer require unique1984/ilkbyte-php-api-connector`

Bulunduğunuz dizinde `composer.json` dosyası ve `vendor` klasörü oluşmuş olacak. An itibariyle `v0.0.1` etiketi bulunmakta, geliştirilmesi devam edilecek bu api connector her versiyonlandığında composer.json dosyasının bulunduğu dizinde `composer update` komutunun verilmesi güncelleme için yeterli olacaktır.

Projenizde kullanmak için, `vendor` klasörü içerisindeki `autoload.php` dosyasını include etmeniz yeterli, ardından ApiConnector nesnesini kullanabiliyor olmalısınız. (Sisteminize ve php kullanım şeklinize göre değişkenlik gösterecektir.) [Examples](https://github.com/unique1984/ilkbyte-php-api-connector/tree/master/Examples) klasörü içerisinde temel uygulama örnekleri mevcut.

Native php projelerinizde kullanabileceğiniz gibi, Symfony, Laravel gibi frameworklerle de uyumludur.

---

`Examples/_inc.php` dosyasının içeriği.
```php
<?php
...
$apiKey = '<API KEY>';
$apiSecret = '<API SECRET>';
$sshPublicKeys = '<PUBLIC SSH KEYS>'; // virgülle ayrılmış

include 'vendor/autoload.php'; // PSR-4 autoloader yükle.
```

*Kodlama PSR-2 Standardında yapılmıştır.*


**ApiConnector Class içerisinde kullanılabilecek methodlar:**

---

`checkApiAccess();`

Yalnızca api erişimini test eder.

[Örnek Kullanım](https://github.com/unique1984/ilkbyte-php-api-connector/blob/master/Examples/checkApiAccess.php) ve var_dump();
```php
/var/www/ilkbytephpapi/PhpApiConnector/example/checkApiAccess.php:21:
array (size=4)
  'api_access' => boolean true
  'documents' => string 'https://github.com/ilkbyte/api.ilkbyte.com/wiki' (length=47)
  'ip_address' => string 'x.x.x.x' (length=14)
  'permission' => string 'Full' (length=4)
```

---

`activeServers();`

[Örnek Kullanım](https://github.com/unique1984/ilkbyte-php-api-connector/blob/master/Examples/activeServers.php)
Hesabınızda kayıtlı aktif sunucuların listesi `array` formunda döner.


```php
/var/www/ilkbytephpapi/PhpApiConnector/example/activeServers.php:21:
array (size=1)
  0 => 
    array (size=9)
      'bandwidth_limit' => int 1073741824000
      'bandwidth_usage' => int 522800567
      'created_time' => string '07.09.2019 04:37:16' (length=19)
      'ipv4' => string 'x.x.x.x' (length=13)
      'ipv6' => string 'xxxx:xxxx:x:xx::xx:x' (length=20)
      'name' => string 'ysntest' (length=7)
      'osapp' => string 'Debian 10 / OpenSSH' (length=19)
      'service' => string 'active' (length=6)
      'status' => string 'nil' (length=3)
```

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