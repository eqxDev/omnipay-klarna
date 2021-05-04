<?php

// $loader = require __DIR__ . '/vendor/autoload.php';
$loader = require  '../vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Klarna\Message\CaptureResponse;
use Omnipay\Klarna\Gateway;
use Examples\Helper;

$gateway = new Gateway();

$helper = new Helper();
try {
    $params = $helper->getCaptureParams();
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}

/** @var CaptureResponse $response */
$response = $gateway->capture($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'message' => $response->getMessage(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
