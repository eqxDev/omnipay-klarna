<?php
/**
 * Klarna Abstract Request
 */

namespace Omnipay\Klarna\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Klarna\Mask;
use Omnipay\Klarna\RequestInterface;
use Omnipay\Common\Exception\InvalidRequestException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest implements RequestInterface
{

    /** @var array */
    protected $requestParams;


    const API_VERSION_EUROPE        = 'EU';
    const API_VERSION_NORTH_AMERICA = 'NA';

    //Europe URL
    const EU_BASE_URL      = 'https://api.klarna.com';
    const EU_TEST_BASE_URL = 'https://api.playground.klarna.com';
    
    //North America URL
    const NA_BASE_URL       = 'https://api-na.klarna.com';
    const NA_TEST_BASE_URL  = 'https://api-na.playground.klarna.com';

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        if (self::API_VERSION_EUROPE === $this->getApiRegion()) {
            return $this->getTestMode() ? self::EU_TEST_BASE_URL : self::EU_BASE_URL;
        }

        return $this->getTestMode() ? self::NA_TEST_BASE_URL : self::NA_BASE_URL;
    }

    /**
     * @return string
     */
    public function getApiRegion(): string
    {
        return $this->getParameter('api_region') ?? self::API_VERSION_EUROPE;
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setApiRegion(string $region): Gateway
    {
        return $this->setParameter('api_region', $region);
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
     * @return Gateway
     */
    public function setUsername(string $value): Gateway
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
     * @return Gateway
     */
    public function setPassword(string $value): Gateway
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
     * @return Gateway
     */
    public function setLocale(string $value): Gateway
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * @return string|null
     */
    public function getMerchantReference1()
    {
        return $this->getParameter('merchant_reference1');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setMerchantReference1(string $value): Gateway
    {
        return $this->setParameter('merchant_reference1', $value);
    }

    /**
     * @return string|null
     */
    public function getMerchantReference2()
    {
        return $this->getParameter('merchant_reference2');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setMerchantReference2(string $value): Gateway
    {
        return $this->setParameter('merchant_reference2', $value);
    }


    /**
     * @param mixed $data
     * @return ResponseInterface|AbstractResponse
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        try {

            $httpRequest = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                ['Content-Type' => 'application/json'],
                http_build_query($data)
            );

            $response = (string)$httpRequest->getBody()->getContents();

            return $this->createResponse($response);
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
    protected function updateValue(string &$data, string $key): void
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
