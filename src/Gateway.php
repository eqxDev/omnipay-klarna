<?php

/**
 * Klarna Class using API
 */

namespace Omnipay\Klarna;

use Omnipay\Klarna\ConstantTrait;
use Omnipay\Common\AbstractGateway;
use Omnipay\Klarna\Messages\RefundRequest;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Klarna\Messages\CaptureRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Klarna\Messages\AuthorizeRequest;
use Omnipay\Klarna\Messages\FetchTransactionRequest;



/**
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    use ConstantTrait;
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
     * @return string
     */
    public function getApiRegion(): string
    {
        return $this->getParameter('apiRegion');
    }

    /**
     * @param string $value
     */
    public function setApiRegion(string $region)
    {
        return $this->setParameter('apiRegion', $region);
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
            'apiRegion' => ''
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
     * @return AbstractRequest|RequestInterface
     */
    public function refund(array $parameters = []): RequestInterface
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function fetchTransaction(array $parameters = []): RequestInterface
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }
}
