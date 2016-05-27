<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\AbstractService;
use SubscribePro\Service\Transaction\TransactionInterface;

/**
 * @method \SubscribePro\Service\PaymentProfile\PaymentProfileInterface createItem(array $data = [])
 * @method \SubscribePro\Service\PaymentProfile\PaymentProfileInterface loadItem(int $spId)
 */
class PaymentProfileService extends AbstractService
{
    /**
     * @var string
     */
    protected $allowedKeysForFilter = [
        PaymentProfileInterface::MAGENTO_CUSTOMER_ID,
        PaymentProfileInterface::CUSTOMER_EMAIL,
    ];

    /**
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $item
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        if ($item->isNew()) {
            $response = $this->httpClient->post($this->getCreateUrl(), [$this->getEntityName() => $item->getFormData()]);
        } else {
            $response = $this->httpClient->put($this->getEntityUrl($item->getId()), [$this->getEntityName() => $item->getFormData()]);
        }

        $itemData = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * Retrieve an array of all payment profiles.
     *  Available filters:
     * - magento_customer_id
     * - customer_email
     *
     * @param array|null $filters
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface[]
     * @throws \RuntimeException
     */
    public function loadItems($filters = [])
    {
        $invalidFilters = is_array($filters)
            ? array_diff_key($filters, array_fill_keys($this->allowedKeysForFilter, null))
            : [];

        if (sizeof($invalidFilters)) {
            throw new \InvalidArgumentException(
                'Only [' . implode(', ', $this->allowedKeysForFilter) . '] query filters are allowed.'
            );
        }

        return parent::loadItems($filters);
    }

    /**
     * @param int $paymentProfileId
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function redact($paymentProfileId)
    {
        $response = $this->httpClient->put("v1/vault/paymentprofiles/{$paymentProfileId}/redact.json");

        $data = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        return $this->createItem($data);
    }

    /**
     * @param int $paymentProfileId
     * @param TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function authorize($paymentProfileId, TransactionInterface $transaction)
    {
        $transactionData = ['transaction' => $transaction->getFormData()];
        $response = $this->httpClient->post("v1/vault/paymentprofiles/{$paymentProfileId}/authorize.json", $transactionData);

        $data = !empty($response['transaction']) ? $response['transaction'] : [];
        $transaction->importData($data);

        return $transaction;
    }

    /**
     * @param int $paymentProfileId
     * @param TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function purchase($paymentProfileId, TransactionInterface $transaction)
    {
        $transactionData = ['transaction' => $transaction->getFormData()];
        $response = $this->httpClient->post("v1/vault/paymentprofiles/{$paymentProfileId}/purchase.json", $transactionData);

        $data = !empty($response['transaction']) ? $response['transaction'] : [];
        $transaction->importData($data);

        return $transaction;
    }

    /**
     * @param int $paymentProfileId
     * @param TransactionInterface $transaction
     * @return \SubscribePro\Service\Transaction\TransactionInterface
     * @throws \RuntimeException
     */
    public function verify($paymentProfileId, TransactionInterface $transaction)
    {
        $transactionData = ['transaction' => $transaction->getVerifyData()];
        $response = $this->httpClient->post("v1/vault/paymentprofiles/{$paymentProfileId}/verify.json", $transactionData);

        $data = !empty($response['transaction']) ? $response['transaction'] : [];
        $transaction->importData($data);

        return $transaction;
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new PaymentProfileFactory(
            $sdk->getAddressService()->getDataFactory(),
            $this->getConfigValue('itemClass', '\SubscribePro\Service\PaymentProfile\PaymentProfile')
        );
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'payment_profile';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'payment_profiles';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return '/v1/vault/paymentprofile.json';
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v1/vault/paymentprofiles/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v1/vault/paymentprofiles.json';
    }
}
