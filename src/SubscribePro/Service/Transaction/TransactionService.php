<?php

namespace SubscribePro\Service\Transaction;

use SubscribePro\Service\AbstractService;

class TransactionService extends AbstractService
{
    /**
     * @param array $data
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     */
    public function createTransaction(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param $id
     * @throws \RuntimeException
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     */
    public function loadTransaction($id)
    {
        return $this->loadItem("/v1/vault/transactions/{$id}.json", 'transaction');
    }

    /**
     * @param int $transactionId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function capture($transactionId, TransactionInterface $transaction)
    {
        $transactionData = ['transaction' => $transaction->getTransactionServiceData()];
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/capture.json", $transactionData);

        $data = !empty($response['transaction']) ? $response['transaction'] : [];
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
        $transactionData = ['transaction' => $transaction->getTransactionServiceData()];
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/credit.json", $transactionData);

        $data = !empty($response['transaction']) ? $response['transaction'] : [];
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

        $data = !empty($response['transaction']) ? $response['transaction'] : [];
        return $this->createItem($data);
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
