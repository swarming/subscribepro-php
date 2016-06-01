<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\AbstractService;

class PaymentProfileService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'payment_profile';

    const API_NAME_PROFILE = 'payment_profile';
    const API_NAME_PROFILES = 'payment_profiles';

    /**
     * @var string
     */
    protected $allowedFilters = [
        PaymentProfileInterface::MAGENTO_CUSTOMER_ID,
        PaymentProfileInterface::CUSTOMER_EMAIL
    ];

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        return new PaymentProfileFactory(
            $sdk->getAddressService()->getDataFactory(),
            $this->getConfigValue('instanceName', '\SubscribePro\Service\PaymentProfile\PaymentProfile')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function createPaymentProfile(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function savePaymentProfile(PaymentProfileInterface $paymentProfile)
    {
        $postData = [self::API_NAME_PROFILE => $paymentProfile->getFormData()];
        $response = $paymentProfile->isNew()
            ? $this->httpClient->post('/v1/vault/paymentprofile.json', $postData)
            : $this->httpClient->put("/v1/vault/paymentprofiles/{$paymentProfile->getId()}.json", $postData);
        return $this->retrieveItem($response, self::API_NAME_PROFILE, $paymentProfile);
    }

    /**
     * @param int $paymentProfileId
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function redact($paymentProfileId)
    {
        $response = $this->httpClient->put("v1/vault/paymentprofiles/{$paymentProfileId}/redact.json");
        return $this->retrieveItem($response, self::API_NAME_PROFILE);
    }

    /**
     * @param int $paymentProfileId
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function loadPaymentProfile($paymentProfileId)
    {
        $response = $this->httpClient->get("/v1/vault/paymentprofiles/{$paymentProfileId}.json");
        return $this->retrieveItem($response, self::API_NAME_PROFILE);
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
        $invalidFilters = array_diff_key($filters, array_flip($this->allowedFilters));
        if (!empty($invalidFilters)) {
            throw new \InvalidArgumentException(
                'Only [' . implode(', ', $this->allowedFilters) . '] query filters are allowed.'
            );
        }

        $response = $this->httpClient->get('/v1/vault/paymentprofiles.json', $filters);
        return $this->retrieveItems($response, self::API_NAME_PROFILES);
    }

    /**
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function saveThirdPartyToken(PaymentProfileInterface $paymentProfile)
    {
        $paymentProfileData = [self::API_NAME_PROFILE => $paymentProfile->getThirdPartyTokenFormData()];
        $response = $this->httpClient->post("/v2/paymentprofile/third-party-token.json", $paymentProfileData);
        return $this->retrieveItem($response, self::API_NAME_PROFILE, $paymentProfile);
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function storeToken($token, PaymentProfileInterface $paymentProfile)
    {
        $postData = ['payment_profile' => $paymentProfile->getTokenFormData()];
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/store.json", $postData);
        return $this->retrieveItem($response, self::API_NAME_PROFILE, $paymentProfile);
    }

    /**
     * @param string $token
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function verifyAndStoreToken($token, PaymentProfileInterface $paymentProfile)
    {
        $postData = ['payment_profile' => $paymentProfile->getTokenFormData()];
        $response = $this->httpClient->post("v1/vault/tokens/{$token}/verifyandstore.json", $postData);
        return $this->retrieveItem($response, self::API_NAME_PROFILE, $paymentProfile);
    }

    /**
     * @param string $token
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     * @throws \RuntimeException
     */
    public function loadPaymentProfileByToken($token)
    {
        $response = $this->httpClient->get("v1/vault/tokens/{$token}/paymentprofile.json");
        return $this->retrieveItem($response, self::API_NAME_PROFILE);
    }
}
