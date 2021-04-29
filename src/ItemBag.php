<?php

namespace Omnipay\Klarna;

class ItemBag extends \Omnipay\Common\ItemBag
{
    /**
     * @inheritDoc
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new Item($item);
        }
    }
}