<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\DataObjectFactoryInterface;

class AddressFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @param string $itemClass
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\Address\Address'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\Address\AddressInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement \\SubscribePro\\Service\\Address\\AddressInterface.");
        }
        $this->itemClass = $itemClass;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->itemClass($data);
    }
}
