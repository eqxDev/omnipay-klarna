<?php
/**
 * Klarna Authorize Request
 */

namespace Omnipay\Klarna\Messages;

use Omnipay\Klarna\Address;
use Omnipay\Klarna\ItemBag;
use Omnipay\Common\Exception\InvalidRequestException;

class AuthorizeRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {

        $data = [
            'order_amount'      => $this->getAmount(),
            'order_tax_amount'  => null === $this->getTaxAmount() ? 0 : (int) $this->getTaxAmount()->getAmount(),
            'order_lines'       => $this->getItemData($this->getItems() ?? new ItemBag()),
            'purchase_currency' => $this->getCurrency(),
            'purchase_country'  => $this->getPurchaseCountry(),
            'auto_capture'      => $this->getAutoCapture()
        ];

        if ($this->getShippingAddress()!==null) {
            $data['shipping_address'] = $this->getShippingAddress();
        }

        if ($this->getBillingAddress()!==null) {
            $data['billing_address'] = $this->getBillingAddress();
        }

        $this->setRequestParams($data);

        return $data;
    }

    /**
     * @return bool
     */
    public function getAutoCapture()
    {
        return $this->getParameter('auto_capture') ?? true;
    }

    /**
     * @return Address|null
     */
    public function getShippingAddress()
    {
        return $this->getParameter('shipping_address');
    }


    /**
     * @param array $shippingAddress
     * @return $this
     */
    public function setShippingAddress(array $shippingAddress): self
    {
        $this->setParameter('shipping_address', $shippingAddress);

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getBillingAddress()
    {
        return $this->getParameter('billing_address');
    }

    /**
     * @param array $billingAddress
     *
     * @return $this
     */
    public function setBillingAddress($billingAddress): self
    {
        $this->setParameter('billing_address', $billingAddress);

        return $this;
    }


    /**
     * @return string|null
     */
    public function getPurchaseCountry()
    {
        return $this->getParameter('purchase_country');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAuthorizationId(string $value): self
    {
        $this->setParameter('authorization_id', $value);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthorizationId()
    {
        return $this->getParameter('authorization_id');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPurchaseCountry(string $value): self
    {
        $this->setParameter('purchase_country', $value);

        return $this;
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


    public function getEndpoint() : string
    {
        return parent::getEndpoint() . '/payments/v1/authorizations/'.$this->getAuthorizationId().'/order';
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

