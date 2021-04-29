<?php
/**
 * Klarna Class using API
 */

namespace Omnipay\Klarna;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Klarna\Messages\AuthorizeRequest;
use Omnipay\Klarna\Messages\CancelRequest;
use Omnipay\Klarna\Messages\CaptureRequest;
use Omnipay\Klarna\Messages\RefundRequest;

/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = [])
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName(): string
    {
        return 'Klarna';
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
     * Default parameters.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'username' => '',
            'password' => '',
            'testMode' => true
        ];
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function authorize(array $parameters = []): RequestInterface
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function capture(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return RequestInterface
     */
    public function refund(array $parameters = []): RequestInterface
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

}
