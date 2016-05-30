<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\AbstractService;
use SubscribePro\Service\Transaction\TransactionInterface;

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
     * @param array $data
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function createPaymentProfile(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $item
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function savePaymentProfile(PaymentProfileInterface $item)
    {
        $createUrl = '/v1/vault/paymentprofile.json';
        $updateUrl = "/v1/vault/paymentprofiles/{$item->getId()}.json";
        return $this->saveItem($item, $createUrl, $updateUrl, 'payment_profile', 'POST', 'PUT');
    }

    /**
     * @param $id
     * @throws \RuntimeException
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function loadPaymentProfile($id)
    {
        return $this->loadItem("/v1/vault/paymentprofiles/{$id}.json", 'payment_profile');
    }

    /**
     * Retrieve an array of all payment profiles.
     *  Available filters:
     * - magento_customer_id
     * - customer_email
     *
     * @param array $filters
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface[]
     * @throws \RuntimeException
     */
    public function loadPaymentProfiles(array $filters = [])
    {
        $invalidFilters = array_diff_key($filters, array_flip($this->allowedKeysForFilter));
        if (!empty($invalidFilters)) {
            throw new \InvalidArgumentException(
                'Only [' . implode(', ', $this->allowedKeysForFilter) . '] query filters are allowed.'
            );
        }

        return $this->loadItems($filters, '/v1/vault/paymentprofiles.json', 'payment_profiles');
    }

    /**
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function thirdPartyToken(PaymentProfileInterface $paymentProfile)
    {
        $paymentProfileData = ['payment_profile' => $paymentProfile->getThirdPartyTokenData()];
        $response = $this->httpClient->post("v2/paymentprofile/third-party-token.json", $paymentProfileData);

        $data = !empty($response['payment_profile']) ? $response['payment_profile'] : [];
        $paymentProfile->importData($data);

        return $paymentProfile;
    }

    /**
     * @param int $paymentProfileId
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function redact($paymentProfileId)
    {
        $response = $this->httpClient->put("v1/vault/paymentprofiles/{$paymentProfileId}/redact.json");

        $data = !empty($response['payment_profile']) ? $response['payment_profile'] : [];
        return $this->createItem($data);
    }

    /**
     * @param int $paymentProfileId
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
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
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
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
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
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
            $this->getConfigValue('instanceName', '\SubscribePro\Service\PaymentProfile\PaymentProfile')
        );
    }
}
