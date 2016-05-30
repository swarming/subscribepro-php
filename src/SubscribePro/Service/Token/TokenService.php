<?php

namespace SubscribePro\Service\Token;

use SubscribePro\Service\AbstractService;
use SubscribePro\Service\Address\AddressInterface;
use SubscribePro\Service\PaymentProfile\PaymentProfileInterface;
use SubscribePro\Service\Transaction\TransactionInterface;

class TokenService extends AbstractService
{

    /**
     * @var \SubscribePro\Service\Token\TokenFactoryInterface
     */
    protected $dataFactory;

    /**
     * @param array $data
     * @return \SubscribePro\Service\Token\TokenInterface
     */
    public function createToken(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param $token
     * @throws \RuntimeException
     * @return \SubscribePro\Service\Token\TokenInterface
     */
    public function loadToken($token)
    {
        return $this->loadItem("/v1/vault/tokens/{$token}.json", 'token');
    }

    /**
     * @param \SubscribePro\Service\Token\TokenInterface $item
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \RuntimeException
     * @throws \BadMethodCallException
     */
    public function saveToken($item)
    {
        return $this->saveItem($item, "/v1/vault/token.json", null, 'token');
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @param \SubscribePro\Service\Address\AddressInterface|null $address
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \RuntimeException
     */
    public function authorize($token, TransactionInterface $transaction, AddressInterface $address = null)
    {
        $data = ['transaction' => $transaction->getCreateByTokenData()];
        if ($address) {
            $data['transaction']['billing_address'] = $address->getFormData();
        }
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/authorize.json", $data);

        $responseData = !empty($response['transaction']) ? $response['transaction'] : [];
        $transaction->importData($responseData);

        return $transaction;
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\Transaction\TransactionInterface $transaction
     * @param \SubscribePro\Service\Address\AddressInterface|null $address
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \RuntimeException
     */
    public function purchase($token, TransactionInterface $transaction, AddressInterface $address = null)
    {
        $data = ['transaction' => $transaction->getCreateByTokenData()];
        if ($address) {
            $data['transaction']['billing_address'] = $address->getFormData();
        }
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/purchase.json", $data);

        $responseData = !empty($response['transaction']) ? $response['transaction'] : [];
        $transaction->importData($responseData);

        return $transaction;
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function store($token, PaymentProfileInterface $paymentProfile)
    {
        $data = ['payment_profile' => $paymentProfile->getCreateByTokenData()];
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/store.json", $data);

        $responseData = !empty($response['payment_profile']) ? $response['payment_profile'] : [];
        $paymentProfile->importData($responseData);

        return $paymentProfile;
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function verifyAndStore($token, PaymentProfileInterface $paymentProfile)
    {
        $data = ['payment_profile' => $paymentProfile->getCreateByTokenData()];
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/verifyandstore.json", $data);

        $responseData = !empty($response['payment_profile']) ? $response['payment_profile'] : [];
        $paymentProfile->importData($responseData);

        return $paymentProfile;
    }

    /**
     * @param int $token
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function paymentProfile($token)
    {
        $response = $this->httpClient->get("v1/vault/tokens/{$token}/paymentprofile.json");
        $data = !empty($response['payment_profile']) ? $response['payment_profile'] : [];

        return $this->createPaymentProfileItem($data);
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new TokenFactory(
            $sdk->getPaymentProfileService()->getDataFactory(),
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Token\Token')
        );
    }

    protected function createPaymentProfileItem(array $data = [])
    {
        return $this->dataFactory->createPaymentProfileItem($data);
    }
}
