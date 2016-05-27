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
    protected $itemClass;

    /**
     * @param \SubscribePro\Service\DataObjectFactoryInterface $addressFactory
     * @param \SubscribePro\Service\DataObjectFactoryInterface $paymentProfileFactory
     * @param string $itemClass
     */
    public function __construct(
        \SubscribePro\Service\DataObjectFactoryInterface $addressFactory,
        \SubscribePro\Service\DataObjectFactoryInterface $paymentProfileFactory,
        $itemClass = '\SubscribePro\Service\Subscription\Subscription'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\Subscription\SubscriptionInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement \\SubscribePro\\Service\\Subscription\\SubscriptionInterface.");
        }
        $this->itemClass = $itemClass;
        $this->addressFactory = $addressFactory;
        $this->paymentProfileFactory = $paymentProfileFactory;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function createItem(array $data = [])
    {
        $addressData = !empty($data[SubscriptionInterface::SHIPPING_ADDRESS])
            ? $data[SubscriptionInterface::SHIPPING_ADDRESS]
            : [];
        $data[SubscriptionInterface::SHIPPING_ADDRESS] = $this->addressFactory->createItem($addressData);

        $paymentProfileData = !empty($data[SubscriptionInterface::PAYMENT_PROFILE])
            ? $data[SubscriptionInterface::PAYMENT_PROFILE]
            : [];
        $data[SubscriptionInterface::PAYMENT_PROFILE] = $this->paymentProfileFactory->createItem($paymentProfileData);

        return new $this->itemClass($data);
    }
}
