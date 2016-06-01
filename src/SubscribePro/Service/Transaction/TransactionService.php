<?php

namespace SubscribePro\Service\Transaction;

use SubscribePro\Service\AbstractService;
use SubscribePro\Service\Address\AddressInterface;

class TransactionService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'transaction';

    const ENTITY_NAME = 'transaction';
    const ENTITIES_NAME = 'transactions';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataFactoryInterface
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        return new TransactionFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Transaction\Transaction')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     */
    public function createTransaction(array $data = [])
    {
        return $this->dataFactory->create($data);
    }

    /**
     * @param int $transactionId
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function loadTransaction($transactionId)
    {
        $response = $this->httpClient->get("/v1/vault/transactions/{$transactionId}.json");
        return $this->retrieveItem($response, self::ENTITY_NAME);
    }

    /**
     * @param int $paymentProfileId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function verifyProfile($paymentProfileId, TransactionInterface $transaction)
    {
        $transactionData = [self::ENTITY_NAME => $transaction->getVerifyData()];
        $response = $this->httpClient->post("v1/vault/paymentprofiles/{$paymentProfileId}/verify.json", $transactionData);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param int $paymentProfileId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function authorizeByProfile($paymentProfileId, TransactionInterface $transaction)
    {
        $transactionData = [self::ENTITY_NAME => $transaction->getFormData()];
        $response = $this->httpClient->post("v1/vault/paymentprofiles/{$paymentProfileId}/authorize.json", $transactionData);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param int $paymentProfileId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function purchaseByProfile($paymentProfileId, TransactionInterface $transaction)
    {
        $transactionData = [self::ENTITY_NAME => $transaction->getFormData()];
        $response = $this->httpClient->post("v1/vault/paymentprofiles/{$paymentProfileId}/purchase.json", $transactionData);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @param \SubscribePro\Service\Address\AddressInterface|null $address
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \RuntimeException
     */
    public function authorizeByToken($token, TransactionInterface $transaction, AddressInterface $address = null)
    {
        $data = ['transaction' => $transaction->getCreateByTokenData()];
        if ($address) {
            $data['transaction']['billing_address'] = $address->getFormData();
        }
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/authorize.json", $data);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @param \SubscribePro\Service\Address\AddressInterface|null $address
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \RuntimeException
     */
    public function purchaseByToken($token, TransactionInterface $transaction, AddressInterface $address = null)
    {
        $data = ['transaction' => $transaction->getCreateByTokenData()];
        if ($address) {
            $data['transaction']['billing_address'] = $address->getFormData();
        }
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/purchase.json", $data);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param int $transactionId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function capture($transactionId, TransactionInterface $transaction)
    {
        $transactionData = [self::ENTITY_NAME => $transaction->getTransactionServiceData()];
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/capture.json", $transactionData);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param int $transactionId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function credit($transactionId, TransactionInterface $transaction)
    {
        $transactionData = [self::ENTITY_NAME => $transaction->getTransactionServiceData()];
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/credit.json", $transactionData);
        return $this->retrieveItem($response, self::ENTITY_NAME, $transaction);
    }

    /**
     * @param int $transactionId
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function void($transactionId)
    {
        $response = $this->httpClient->post("v1/vault/transactions/{$transactionId}/void.json");
        return $this->retrieveItem($response, self::ENTITY_NAME);
    }
}
