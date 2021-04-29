<?php

namespace Omnipay\Klarna\Messages;


class AuthorizeResponse extends AbstractResponse
{
    /**
     * @return string
     */
    public function getClientToken(): string
    {
        return $this->data['client_token'] ?? null;
    }

    public function getData()
    {
        return ['klarnaToken' => $this->isSuccessful() ? $this->getClientToken() : ''];
    }
}