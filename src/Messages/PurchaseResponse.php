<?php

namespace Omnipay\Klarna\Messages;

class PurchaseResponse extends AbstractResponse
{

    /**
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->data['order_id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return $this->data['redirect_url'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getFraudStatus()
    {
        return $this->data['fraud_status'] ?? null;
    }

    /**
     * @return array|null
     */
    public function getAuthorizedPaymentMethod()
    {
        return $this->data['authorized_payment_method'] ?? null;
    }

    public function getData()
    {
        $response = [];
        if ($this->isSuccessful()) {
            $response['fraud_status'] = $this->getFraudStatus();
            $response['order_id'] = $this->getOrderId();
            $response['redirect_url'] = $this->getRedirectUrl();
            $response['authorized_payment_method'] = $this->getAuthorizedPaymentMethod();
        }
        return $response;
    }
}
