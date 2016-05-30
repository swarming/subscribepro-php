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
     * @param int $transactionId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function capture($transactionId, TransactionInterface $transaction)
    {
        $transactionData = [$this->getEntityName() => $transaction->getTransactionServiceData()];
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/capture.json", $transactionData);

        $data = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        $transaction->importData($data);

        return $transaction;
    }

    /**
     * @param int $transactionId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function credit($transactionId, TransactionInterface $transaction)
    {
        $transactionData = [$this->getEntityName() => $transaction->getTransactionServiceData()];
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/credit.json", $transactionData);

        $data = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        $transaction->importData($data);

        return $transaction;
    }

    /**
     * @param int $transactionId
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function void($transactionId)
    {
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/void.json");

        $data = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        return $this->createItem($data);
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
        return "";
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v1/vault/transactions/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '';
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new TransactionFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Transaction\Transaction')
        );
    }
}
