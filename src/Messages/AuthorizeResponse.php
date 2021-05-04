<?php

namespace Omnipay\Klarna\Messages;

class AuthorizeResponse extends AbstractResponse
{
    /**
     * @return string|null
     */
    public function getClientToken(): ?string
    {
        return $this->data['client_token'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->data['session_id'] ?? null;
    }

    /**
     * @return array|null
     */
    public function getPaymentMethodCategories(): ?array
    {
        return $this->data['payment_method_categories'] ?? null;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $response = [];
        if ($this->isSuccessful()) {
            $response['session_id'] = $this->getSessionId();
            $response['client_token'] = $this->getClientToken();
            $response['payment_method_categories'] = $this->getPaymentMethodCategories();
        }
        return $response;
    }
}
