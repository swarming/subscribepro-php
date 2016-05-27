<?php

namespace SubscribePro\Service\Transaction;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Transaction\TransactionInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Transaction\TransactionInterface loadItem(int $spId)
 */
class TransactionService extends AbstractService
{
    /**
     * @param \SubscribePro\Service\DataObjectInterface $item
     * @return void
     * @throws \BadMethodCallException
     */
    public function saveItem($item)
    {
        throw new \BadMethodCallException('Save method not implemented in transaction service.');
    }

    /**
     * @param mixed $filters
     * @return void
     * @throws \BadMethodCallException
     */
    public function loadItems($filters = null)
    {
        throw new \BadMethodCallException('Load items method not implemented in transaction service.');
    }
    
    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'transaction';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'transactions';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return "/v2/transaction";
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v2/transactions/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v2/transactions.json';
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new TransactionFactory(
            $this->getConfigValue('itemClass', '\SubscribePro\Service\Transaction\Transaction')
        );
    }
}
