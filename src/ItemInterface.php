<?php

namespace Omnipay\Klarna;

interface ItemInterface extends \Omnipay\Common\ItemInterface
{

    public function getMerchantData();
    public function getTaxRate();
    public function getTotalAmount();
    public function getTotalDiscountAmount();
    public function getTotalTaxAmount();
    public function getType();
}
