<?php

namespace SubscribePro\Service\Transaction;

use SubscribePro\Service\DataObjectFactoryInterface;

class TransactionFactory implements DataObjectFactoryInterface
{
    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @param string $itemClass
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\Transaction\Transaction'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\Transaction\TransactionInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement \\SubscribePro\\Service\\Transaction\\TransactionInterface.");
        }
        $this->itemClass = $itemClass;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     */
    public function createItem(array $data = [])
    {
        return new $this->itemClass($data);
    }
}
