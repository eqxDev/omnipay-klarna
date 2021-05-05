<?php

namespace Omnipay\Klarna\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class CaptureRequest extends AbstractRequest
{
    use OrderRequestTrait;

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {

        $data = $this->getOrderData();
        $data['autoCapture'] = $this->getAutoCapture();
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
        return 'CAPTURE';
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Capture';
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
     * @return CaptureResponse
     */
    protected function createResponse($data): CaptureResponse
    {
        $response = new CaptureResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
