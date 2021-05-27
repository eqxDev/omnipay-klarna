# omnipay-klarna
<p>
<a href="https://github.com/alegraio/omnipay-klarna/actions"><img src="https://github.com/alegraio/omnipay-klarna/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/alegra/omnipay-klarna"><img src="https://img.shields.io/packagist/dt/alegra/omnipay-klarna" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/alegra/omnipay-klarna"><img src="https://img.shields.io/packagist/v/alegra/omnipay-klarna" alt="Latest Stable Version"></a>
</p>

Klarna gateway for Omnipay payment processing library

<a href="https://github.com/thephpleague/omnipay">Omnipay</a> is a framework agnostic, multi-gateway payment
processing library for PHP 7.3+. This package implements Klarna Online Payment Gateway support for Omnipay.

* You have to contact the Garanti(Gvp) for the document.


## Requirement

* PHP >= 7.3.x,
* [Omnipay V.3](https://github.com/thephpleague/omnipay) repository,
* PHPUnit to run tests

## Autoload

You have to install omnipay V.3

```bash
composer require league/omnipay:^3
```

Then you have to install omnipay-payu package:

```bash
composer require alegra/omnipay-klarna
```

> `payment-klarna` follows the PSR-4 convention names for its classes, which means you can easily integrate `payment-klarna` classes loading in your own autoloader.

## Basic Usage

- You can use /examples folder to execute examples. This folder is exists here only to show you examples, it is not for production usage.
- First in /examples folder:

```bash
composer install
```

**Authorize Example**

- You can check authorize.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Klarna\Message\AuthorizeResponse;
use Omnipay\Klarna\Gateway;
use Examples\Helper;

$gateway = new Gateway();

$helper = new Helper();
try {
    $params = $helper->getAuthorizeParams();

    /** @var AuthorizeResponse $response */
    $response = $gateway->authorize($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'message' => $response->getMessage(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}

```
**Purchase Example**

- You can check purchase.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Klarna\Message\PurchaseResponse;
use Omnipay\Klarna\Gateway;
use Examples\Helper;

$gateway = new Gateway();

$helper = new Helper();
try {
    $params = $helper->getPurchaseParams();

    /** @var PurchaseResponse $response */
    $response = $gateway->authorize($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'message' => $response->getMessage(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}

```

**Refund Example**

- You can check refund.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Klarna\Gateway;
use Examples\Helper;

$gateway = new Gateway();
$helper = new Helper();

try {
    $params = $helper->getRefundParams();
    $response = $gateway->refund($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'redirect' => $response->isRedirect() ?: 0,
        'message' => $response->getMessage(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}

```
requestParams:

> System send request to klarna api. It shows request information.
>