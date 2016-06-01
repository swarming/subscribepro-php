<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\DataObjectFactoryInterface;

class SubscriptionFactory implements DataObjectFactoryInterface
{
    /**
     * @var \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected $addressFactory;

    /**
     * @var \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected $paymentProfileFactory;

    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @param \SubscribePro\Service\DataObjectFactoryInterface $addressFactory
     * @param \SubscribePro\Service\DataObjectFactoryInterface $paymentProfileFactory
     * @param string $instanceName
     */
    public function __construct(
        \SubscribePro\Service\DataObjectFactoryInterface $addressFactory,
        \SubscribePro\Service\DataObjectFactoryInterface $paymentProfileFactory,
        $instanceName = '\SubscribePro\Service\Subscription\Subscription'
    ) {
        if (!is_subclass_of($instanceName, '\SubscribePro\Service\Subscription\SubscriptionInterface')) {
            throw new \InvalidArgumentException("{$instanceName} must implement \\SubscribePro\\Service\\Subscription\\SubscriptionInterface.");
        }
        $this->instanceName = $instanceName;
        $this->addressFactory = $addressFactory;
        $this->paymentProfileFactory = $paymentProfileFactory;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function createItem(array $data = [])
    {
        $addressData = $this->getFieldData($data, SubscriptionInterface::SHIPPING_ADDRESS);
        $data[SubscriptionInterface::SHIPPING_ADDRESS] = $this->addressFactory->createItem($addressData);

        $paymentProfileData = $this->getFieldData($data, SubscriptionInterface::PAYMENT_PROFILE);
        $data[SubscriptionInterface::PAYMENT_PROFILE] = $this->paymentProfileFactory->createItem($paymentProfileData);

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
