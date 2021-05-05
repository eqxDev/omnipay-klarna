<?php

namespace OmnipayTest\Klarna;


use Omnipay\Klarna\Gateway;
use Omnipay\Tests\GatewayTestCase;
use Omnipay\Klarna\Messages\RefundRequest;
use Omnipay\Klarna\Messages\CaptureRequest;
use Omnipay\Klarna\Messages\AuthorizeRequest;
use Omnipay\Klarna\Messages\FetchTransactionRequest;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    public $gateway;

    public function setUp()
    {
        /** @var Gateway gateway */
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        /*$this->gateway->setUsername('xxx');
        $this->gateway->setPassword('xxx');
        $this->gateway->setApiRegion('xx');
        $this->gateway->setTestMode(true);*/
    }

    public function testAuthorize(): void
    {

        $params = [
            "locale" => "en-GB",
            "purchaseCountry" => "GB",
            "currency" => "GBP",
            "amount" => 2500,
            "taxAmount" => 0,
            "items" => [
                [
                    "name" => "Running shoe",
                    "quantity" => 1,
                    "total_amount" => 2500,
                    "price" => 2500
                ]
            ],
            'merchantReference1' => 'authtest01',

        ];

        $request = $this->gateway->authorize($params);

        /** @var AuthorizeResponse $response */
        /*$response = $request->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getData());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());*/
        self::assertInstanceOf(AuthorizeRequest::class, $request);
    }

    public function testCapture(): void
    {

        $params = [
            "locale" => "en-GB",
            "purchaseCountry" => "GB",
            "currency" => "GBP",
            "amount" => 2500,
            "taxAmount" => 0,
            "items" => [
                [
                    "name" => "Running shoe",
                    "quantity" => 2,
                    "total_amount" => 5000,
                    "price" => 2500
                ]
            ],
            'merchantReference1' => 'capturetest01',
            "authorizationToken" => "d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f",
        ];

        $request = $this->gateway->capture($params);

        /** @var CaptureResponse $response */
        /*$response = $request->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());*/
        self::assertInstanceOf(CaptureRequest::class, $request);
    }

    public function testRefund(): void
    {

        $params = [
            "transactionReference" => "d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f",
            "amount" => 100
        ];

        $request = $this->gateway->refund($params);

        /** @var RefundResponse $response */
        /*$response = $request->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());*/
        self::assertInstanceOf(RefundRequest::class, $request);

    }

    public function testFetchTransaction(): void
    {

        $params = [
            "transactionReference" => "d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f"
        ];

        $request = $this->gateway->fetchTransaction($params);

        /** @var RefundResponse $response */
        /*$response = $request->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());*/
        self::assertInstanceOf(FetchTransactionRequest::class, $request);
    }
}
