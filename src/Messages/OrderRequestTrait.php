<?php

namespace Omnipay\Klarna\Messages;

use Omnipay\Klarna\Address;

trait OrderRequestTrait
{
    public function getOrderData()
    {
        $data = [
            'locale'            => $this->getLocale(),
            'purchase_currency' => $this->getCurrency(),
            'purchase_country'  => $this->getPurchaseCountry(),
            'order_amount'      => (float)$this->getAmount(),
            'order_tax_amount'  => null === $this->getTaxAmount() ? 0 : (int) $this->getTaxAmount(),
        ];

        $items = $this->getItems();

        if ($items) {

            $itemList = [];

            foreach ($items as $n => $item) {
                $itemList[] = [
                    'name' => $item->getName(),
                    'quantity' => $item->getQuantity(),
                    'tax_rate' => null === $item->getTaxRate() ? null : (int) ($item->getTaxRate() * 100),
                    'total_amount' => (int) $item->getPrice() * (float)$item->getQuantity(),
                    'unit_price' => (int) $item->getPrice(),
                    'merchant_data' => $item->getMerchantData()
                ];
            }
            $data['order_lines'] = $itemList;

        }

        if (null !== $shippingAddress = $this->getShippingAddress()) {
            $data['shipping_address'] = $shippingAddress->getArrayCopy();
        }

        if (null !== $billingAddress = $this->getBillingAddress()) {
            $data['billing_address'] = $billingAddress->getArrayCopy();
        }

        if (null !== $merchantReference1 = $this->getMerchantReference1()) {
            $data['merchant_reference1'] = $merchantReference1;
        }

        if (null !== $merchantReference2 = $this->getMerchantReference2()) {
            $data['merchant_reference2'] = $merchantReference2;
        }

        return $data;
    }

    /**
     * @param mixed $value
     */
    public function getTaxAmount()
    {
        return $this->getParameter('taxAmount');
    }

    public function setTaxAmount($value)
    {
        return $this->setParameter('taxAmount', $value);
    }

    /**
     * @return string|null
     */
    public function getMerchantReference1()
    {
        return $this->getParameter('merchantReference1');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMerchantReference1(string $value)
    {
        return $this->setParameter('merchantReference1', $value);
    }

    /**
     * @return string|null
     */
    public function getMerchantReference2()
    {
        return $this->getParameter('merchantReference2');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMerchantReference2(string $value)
    {
        return $this->setParameter('merchantReference2', $value);
    }

    /**
     * @return string|null
     */
    public function getPurchaseCountry()
    {
        return $this->getParameter('purchaseCountry');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPurchaseCountry(string $value): self
    {
        return $this->setParameter('purchaseCountry', $value);
    }

    /**
     * @return Address|null
     */
    public function getShippingAddress()
    {
        return $this->getParameter('shippingAddress');
    }


    /**
     * @param array $shippingAddress
     * @return $this
     */
    public function setShippingAddress(array $shippingAddress): self
    {
        return $this->setParameter('shippingAddress',  Address::fromArray($shippingAddress));
    }

    /**
     * @return Address|null
     */
    public function getBillingAddress()
    {
        return $this->getParameter('billingAddress');
    }

    /**
     * @param array $billingAddress
     * @return $this
     */
    public function setBillingAddress($billingAddress): self
    {
        return $this->setParameter('billingAddress', Address::fromArray($billingAddress));
    }
}