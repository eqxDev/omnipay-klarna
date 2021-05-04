<?php

namespace Omnipay\Klarna\Messages;

use Omnipay\Klarna\Mask;
use Omnipay\Common\ItemBag;
use Omnipay\Klarna\ConstantTrait;
use Omnipay\Klarna\RequestInterface;
use Omnipay\Klarna\ItemBag as KlarnaItemBag;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Klarna\Messages\AbstractResponse;
use Omnipay\Common\Exception\InvalidResponseException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest implements RequestInterface
{
    use ConstantTrait;

    /** @var array */
    protected $requestParams;

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        if ($this->api_version_europe === $this->getApiRegion()) {
            return $this->getTestMode() ? $this->eu_test_base_url : $this->eu_base_url;
        }

        return $this->getTestMode() ? $this->na_test_base_url : $this->na_base_url;
    }


    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getParameter('username');
    }

    /**
     * @param string $value
     */
    public function setUsername(string $value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $value
     */
    public function setPassword(string $value)
    {
        return $this->setParameter('password', $value);
    }


    /**
     * @return string|null
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * @param string $value
     */
    public function setLocale(string $value)
    {
        return $this->setParameter('locale', $value);
    }


    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new KlarnaItemBag($items);
        }

        return $this->setParameter('items', $items);
    }

    public function getAuthorization()
    {
        return  sprintf(
            'Basic %s',
            base64_encode(
                sprintf(
                    '%s:%s',
                    $this->getUsername(),
                    $this->getPassword()
                )
            )
        );
    }


    /**
     * @param mixed $data
     * @return ResponseInterface|AbstractResponse
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {

        $body = null;

        if (empty($data)) {
            $body = null;
        } else {
            $body = json_encode($data);
        }

        $requestUrl = $this->getEndpoint();

        $headerParams = array(
            'Accept'         => 'application/json',
            'Authorization'  => $this->getAuthorization(),
            'Content-type'   => 'application/json',
        );

        try {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $requestUrl,
                $headerParams,
                $body
            );

            // Empty response body should be parsed also as and empty array
            $response = (string) $httpResponse->getBody()->getContents();

            $jsonToArrayResponse = !empty($response) ? json_decode($response, true, 512, JSON_THROW_ON_ERROR) : array();
            return $this->response = $this->createResponse($jsonToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @param array $data
     */
    protected function setRequestParams(array $data): void
    {
        array_walk_recursive($data, [$this, 'updateValue']);
        $this->requestParams = $data;
    }

    /**
     * @param string $data
     * @param string $key
     */
    protected function updateValue(&$data, $key): void
    {
        $sensitiveData = $this->getSensitiveData();

        if (\in_array($key, $sensitiveData, true)) {
            $data = Mask::mask($data);
        }
    }

    /**
     * @return array
     */
    protected function getRequestParams(): array
    {
        return [
            'url' => $this->getEndPoint(),
            'type' => $this->getProcessType(),
            'data' => $this->requestParams,
            'method' => $this->getHttpMethod()
        ];
    }
}
