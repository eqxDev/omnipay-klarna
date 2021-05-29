<?php

namespace Examples;


class Helper
{
    
    public function getAuthorizeParams(): array
    {

        $params = [
            "locale" => "en-GB",
            "purchase_country" => "GB",
            "currency" => "GBP",
            "amount"=> 2500,
            "tax_amount"=> 0,
            "items"=> [
                [    
                    "name"=> "Running shoe",
                    "quantity"=> 1,
                    "total_amount"=> 2500,
                    "price"=> 2500
                ]
            ]
        ];

        return $this->provideMergedParams($params);
    }

    public function getPurchaseParams(): array
    {

        $params = [
            "locale" => "en-GB",
            "purchase_country" => "GB",
            "currency" => "GBP",
            "amount"=> 2500,
            "tax_amount"=> 0,
            "items"=> [
                [    
                    "name"=> "Running shoe",
                    "quantity"=> 1,
                    "total_amount"=> 2500,
                    "price"=> 2500
                ]
            ],
            "authorization_token"=>"d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f"
        ];

        return $this->provideMergedParams($params);
    }

    public function getRefundParams(): array
    {

        $params = [
            "transactionReference"=>"d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f"
        ];

        return $this->provideMergedParams($params);
    }

    public function getFetchTransactionParams(): array
    {

        $params = [
            "transactionReference"=>"d8bcb0ac-deeb-325b-8472-ef2c4b9b3e8f"
        ];

        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'username' => 'USERNAME',
            'password' => 'PASSWORD',
            'apiRegion' => 'EU',
        ];
    }

    private function provideMergedParams($params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }

}

