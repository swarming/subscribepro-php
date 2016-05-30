<?php

namespace SubscribePro\Service\Token;

use SubscribePro\Service\AbstractService;
use SubscribePro\Service\Address\AddressInterface;
use SubscribePro\Service\PaymentProfile\PaymentProfileInterface;
use SubscribePro\Service\Transaction\TransactionInterface;

/**
 * @method \SubscribePro\Service\Token\TokenInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Token\TokenInterface loadItem(string $token)
 */
class TokenService extends AbstractService
{

    /**
     * @var \SubscribePro\Service\Token\TokenFactoryInterface
     */
    protected $dataFactory;

    /**
     * @param mixed $filters
     * @return void
     * @throws \BadMethodCallException
     */
    public function loadItems($filters = null)
    {
        throw new \BadMethodCallException('Load items method not implemented in token service.');
    }
    /**
     * @param \SubscribePro\Service\Token\TokenInterface $item
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getCreateUrl(), [$this->getEntityName() => $item->getFormData()]);

        $itemData = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        $item->importData($itemData);

        return $item;
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
     * @return string
     */
    protected function getEntityName()
    {
        return 'token';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'tokens';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return "/v1/vault/token.json";
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v1/vault/tokens/{$id}.json";
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
