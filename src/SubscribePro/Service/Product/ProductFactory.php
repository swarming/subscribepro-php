<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\DataObjectFactoryInterface;

class ProductFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @param string $instanceName
     */
    public function __construct(
        $instanceName = '\SubscribePro\Service\Product\Product'
    ) {
        if (!is_subclass_of($instanceName, '\SubscribePro\Service\Product\ProductInterface')) {
            throw new \InvalidArgumentException("{$instanceName} must implement \\SubscribePro\\Service\\Product\\ProductInterface.");
        }
        $this->instanceName = $instanceName;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->instanceName($data);
    }
}
