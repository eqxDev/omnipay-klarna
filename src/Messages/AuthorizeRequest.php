<?php
/**
 * Klarna Authorize Request
 */

namespace Omnipay\Klarna\Messages;

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
            'purchase_currency' => $this->getCurrency(),
            'purchase_country'  => $this->getPurchaseCountry(),
            'order_amount'      => $this->getAmount(),
            'order_tax_amount'  => null === $this->getTaxAmount() ? 0 : (int) $this->getTaxAmount()->getAmount(),
            'order_lines'       => $this->getItemData($this->getItems() ?? new ItemBag())
        ];

        $this->setRequestParams($data);

        return $data;
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
    public function setPurchaseCountry(string $value): self
    {
        return $this->setParameter('purchase_country', $value);
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
     * @return array
     */
    public function getSensitiveData(): array
    {
        return [];
    }

    /**
     * @return string
    */
    public function getEndpoint() : string
    {
        return parent::getEndpoint() . '/payments/v1/sessions';
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

