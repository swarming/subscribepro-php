<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\DataObjectFactoryInterface;

class ProductFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @param string $itemClass
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\Product\Product'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\Product\ProductInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement \\SubscribePro\\Service\\Product\\ProductInterface.");
        }
        $this->itemClass = $itemClass;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->itemClass($data);
    }
}
