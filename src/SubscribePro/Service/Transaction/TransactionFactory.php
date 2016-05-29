<?php

namespace SubscribePro\Service\Transaction;

use SubscribePro\Service\DataObjectFactoryInterface;

class TransactionFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @param string $instanceName
     */
    public function __construct(
        $instanceName = '\SubscribePro\Service\Transaction\Transaction'
    ) {
        if (!is_a($instanceName, '\SubscribePro\Service\Transaction\TransactionInterface', true)) {
            throw new \InvalidArgumentException("{$instanceName} must implement \\SubscribePro\\Service\\Transaction\\TransactionInterface.");
        }
        $this->instanceName = $instanceName;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->instanceName($data);
    }
}
