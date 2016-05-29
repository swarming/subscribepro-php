<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\DataObjectFactoryInterface;

class AddressFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @param string $instanceName
     */
    public function __construct(
        $instanceName = '\SubscribePro\Service\Address\Address'
    ) {
        if (!is_a($instanceName, '\SubscribePro\Service\Address\AddressInterface', true)) {
            throw new \InvalidArgumentException("{$instanceName} must implement \\SubscribePro\\Service\\Address\\AddressInterface.");
        }
        $this->instanceName = $instanceName;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->instanceName($data);
    }
}
