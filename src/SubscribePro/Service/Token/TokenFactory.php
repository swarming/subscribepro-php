<?php

namespace SubscribePro\Service\Token;

class TokenFactory implements TokenFactoryInterface
{
    /**
     * @var \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected $paymentProfileFactory;

    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @param \SubscribePro\Service\DataObjectFactoryInterface $paymentProfileFactory
     * @param string $instanceName
     */
    public function __construct(
        \SubscribePro\Service\DataObjectFactoryInterface $paymentProfileFactory,
        $instanceName = '\SubscribePro\Service\Token\Token'
    ) {
        if (!is_a($instanceName, '\SubscribePro\Service\Token\TokenInterface', true)) {
            throw new \InvalidArgumentException("{$instanceName} must implement \\SubscribePro\\Service\\Token\\TokenInterface.");
        }
        $this->instanceName = $instanceName;
        $this->paymentProfileFactory = $paymentProfileFactory;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Token\TokenInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->instanceName($data);
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function createPaymentProfileItem(array $data = [])
    {
        return $this->paymentProfileFactory->createItem($data);
    }
}
