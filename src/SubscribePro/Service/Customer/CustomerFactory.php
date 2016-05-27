<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\DataObjectFactoryInterface;

class CustomerFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @param string $itemClass
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\Customer\Customer'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\Customer\CustomerInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement \\SubscribePro\\Service\\Customer\\CustomerInterface.");
        }
        $this->itemClass = $itemClass;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Customer\CustomerInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->itemClass($data);
    }
}
