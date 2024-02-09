<?php

namespace Omnipay\Klarna\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class AuthorizeRequest extends AbstractRequest
{
    use OrderRequestTrait;

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $data = $this->getOrderData();

        $this->setRequestParams($data);

        return $data;
    }


    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'AUTHORIZE';
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Authorize';
    }

    /**
     * @return string|null
     */
    public function getSessionId()
    {
        return $this->getParameter('sessionId');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSessionId(string $value): self
    {
        return $this->setParameter('sessionId', $value);
    }

    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        if ($this->getSessionId() == null) {
            return parent::getEndpoint() . '/payments/v1/sessions';
        }

        return parent::getEndpoint() . '/payments/v1/sessions/' . $this->getSessionId();
    }

    /**
     * @param $data
     * @return AuthorizeResponse
     */
    protected function createResponse($data): AuthorizeResponse
    {
        $response = new AuthorizeResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
