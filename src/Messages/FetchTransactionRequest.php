<?php

namespace Omnipay\Klarna\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class FetchTransactionRequest extends AbstractRequest
{
    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'FETCH';
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Fetch';
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
        return parent::getEndpoint() . '/ordermanagement/v1/orders/' . $this->getTransactionReference();
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
