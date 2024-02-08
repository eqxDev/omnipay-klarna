<?php

namespace Omnipay\Klarna;

use Omnipay\Klarna\ItemInterface;

class Item extends \Omnipay\Common\Item implements ItemInterface
{
    /**
     * @inheritDoc
     */
    public function getMerchantData()
    {
        return $this->getParameter('merchant_data');
    }

    /**
     * @param string $data
     */
    public function setMerchantData($data)
    {
        $this->setParameter('merchant_data', $data);
    }

    /**
     * @inheritDoc
     */
    public function getTaxRate()
    {
        return $this->getParameter('tax_rate');
    }

    /**
     * @param int $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->setParameter('tax_rate', $taxRate);
    }

    /**
     * @inheritDoc
     */
    public function getTotalAmount()
    {
        return $this->getParameter('total_amount');
    }

    /**
     * @param int $amount
     */
    public function setTotalAmount($amount)
    {
        $this->setParameter('total_amount', $amount);
    }

    /**
     * @inheritDoc
     */
    public function getTotalDiscountAmount()
    {
        return $this->getParameter('total_discount_amount');
    }

    /**
     * @param int $amount
     */
    public function setTotalDiscountAmount($amount)
    {
        $this->setParameter('total_discount_amount', $amount);
    }

    /**
     * @inheritDoc
     */
    public function getTotalTaxAmount()
    {
        return $this->getParameter('total_tax_amount');
    }


    /**
     * @param int $amount
     */
    public function setTotalTaxAmount($amount)
    {
        $this->setParameter('total_tax_amount', $amount);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->setParameter('type', $type);
    }

    public function getReference()
    {
        return $this->getParameter('reference');
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->setParameter('reference', $reference);
    }
}
