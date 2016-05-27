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
    protected $itemClass;

    /**
     * @param \SubscribePro\Service\DataObjectFactoryInterface $addressFactory
     * @param string $itemClass
     */
    public function __construct(
        \SubscribePro\Service\DataObjectFactoryInterface $addressFactory,
        $itemClass = '\SubscribePro\Service\PaymentProfile\PaymentProfile'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\PaymentProfile\PaymentProfileInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement \\SubscribePro\\Service\\PaymentProfile\\PaymentProfileInterface.");
        }
        $this->itemClass = $itemClass;
        $this->addressFactory = $addressFactory;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function createItem(array $data = [])
    {
        $addressData = !empty($data[PaymentProfileInterface::BILLING_ADDRESS])
            ? $data[PaymentProfileInterface::BILLING_ADDRESS]
            : [];
        $data[PaymentProfileInterface::BILLING_ADDRESS] = $this->addressFactory->createItem($addressData);

        return new $this->itemClass($data);
    }
}
