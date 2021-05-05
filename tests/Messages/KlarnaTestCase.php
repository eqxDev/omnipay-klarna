<?php

namespace OmnipayTest\Klarna\Messages;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class KlarnaTestCase extends TestCase
{
    protected function getAuthorizeParams(): array
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

        return $this->provideMergedParams($params);
    }

    protected function getCaptureParams(): array
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
            'merchantReference1' => 'capturetest01',
            "authorizationToken" => "d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f",
        ];

        return $this->provideMergedParams($params);
    }

    protected function getRefundParams(): array
    {

        $params = [
            "transactionReference" => "d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f",
            'amount'=>'100'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getFetchTransactionParams(): array
    {

        $params = [
            "transactionReference" => "d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f"
        ];

        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'username' => 'USERNAME',
            'password' => 'PASSWORD',
            'apiRegion' => 'API_REGION',
        ];
    }

    private function provideMergedParams($params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }
}
