<?php

namespace Omnipay\Klarna\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    use OrderRequestTrait;

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {

        $data = $this->getOrderData();
        $data['auto_capture'] = $this->getAutoCapture();
        $this->setRequestParams($data);

        return $data;
    }

    /**
     * @return bool
     */
    public function getAutoCapture()
    {
        return $this->getParameter('autoCapture') ?? true;
    }


    /**
     * @return string|null
     */
    public function getAuthorizationToken()
    {
        return $this->getParameter('authorizationToken');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAuthorizationToken(string $value): self
    {
        return $this->setParameter('authorizationToken', $value);
    }


    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'PURCHASE';
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Purchase';
    }

    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return [];
    }


    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/payments/v1/authorizations/' . $this->getAuthorizationToken() . '/order';
    }

    /**
     * @param $data
     * @return PurchaseResponse
     */
    protected function createResponse($data): PurchaseResponse
    {
        $response = new PurchaseResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
