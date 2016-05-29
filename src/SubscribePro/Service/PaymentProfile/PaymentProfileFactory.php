<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\DataObjectFactoryInterface;

class PaymentProfileFactory implements DataObjectFactoryInterface
{
    /**
     * @var \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected $addressFactory;

    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @param \SubscribePro\Service\DataObjectFactoryInterface $addressFactory
     * @param string $instanceName
     */
    public function __construct(
        \SubscribePro\Service\DataObjectFactoryInterface $addressFactory,
        $instanceName = '\SubscribePro\Service\PaymentProfile\PaymentProfile'
    ) {
        if (!is_a($instanceName, '\SubscribePro\Service\PaymentProfile\PaymentProfileInterface', true)) {
            throw new \InvalidArgumentException("{$instanceName} must implement \\SubscribePro\\Service\\PaymentProfile\\PaymentProfileInterface.");
        }
        $this->instanceName = $instanceName;
        $this->addressFactory = $addressFactory;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function createItem(array $data = [])
    {
        $addressData = $this->getFieldData($data, PaymentProfileInterface::BILLING_ADDRESS);
        $data[PaymentProfileInterface::BILLING_ADDRESS] = $this->addressFactory->createItem($addressData);

        return new $this->instanceName($data);
    }

    /**
     * @param array $data
     * @param string $field
     * @return array
     */
    protected function getFieldData($data, $field)
    {
        return !empty($data[$field]) ? $data[$field] : [];
    }
}
