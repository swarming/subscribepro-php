<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\DataObjectInterface;
use SubscribePro\Service\Address\AddressInterface;

interface PaymentProfileInterface extends DataObjectInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const MAGENTO_CUSTOMER_ID = 'magento_customer_id';
    const CUSTOMER_EMAIL = 'customer_email';
    const CREDITCARD_TYPE = 'creditcard_type';
    const CREDITCARD_NUMBER = 'creditcard_number';
    const CREDITCARD_FIRST_DIGITS = 'creditcard_first_digits';
    const CREDITCARD_LAST_DIGITS = 'creditcard_last_digits';
    const CREDITCARD_VERIFICATION_VALUE = 'creditcard_verification_value';
    const CREDITCARD_MONTH = 'creditcard_month';
    const CREDITCARD_YEAR = 'creditcard_year';
    const BILLING_ADDRESS = 'billing_address';
    const GATEWAY = 'gateway';
    const PAYMENT_METHOD_TYPE = 'payment_method_type';
    const PAYMENT_TOKEN = 'payment_token';
    const PAYMENT_VAULT = 'payment_vault';
    const THIRD_PARTY_VAULT_TYPE = 'third_party_vault_type';
    const THIRD_PARTY_PAYMENT_TOKEN = 'third_party_payment_token';
    const STATUS = 'status';
    const CREATED = 'created';
    const UPDATED = 'updated';

    /**
     * @return string|null
     */
    public function getCustomerId();

    /**
     * @param string $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * @return string|null
     */
    public function getMagentoCustomerId();

    /**
     * @param string $magentoCustomerId
     * @return $this
     */
    public function setMagentoCustomerId($magentoCustomerId);

    /**
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * @return string|null
     */
    public function getCreditcardType();

    /**
     * @return string
     */
    public function getCreditcardNumber();

    /**
     * @param string $creditcardNumber
     * @return $this
     */
    public function setCreditcardNumber($creditcardNumber);

    /**
     * @return string
     */
    public function getCreditcardFirstDigits();

    /**
     * @param string $creditcardFirstDigits
     * @return $this
     */
    public function setCreditcardFirstDigits($creditcardFirstDigits);

    /**
     * @param string $creditcardLastDigits
     * @return $this
     */
    public function setCreditcardLastDigits($creditcardLastDigits);

    /**
     * @return string
     */
    public function getCreditcardLastDigits();

    /**
     * @return string|null
     */
    public function getCreditcardVerificationValue();

    /**
     * @param string $creditcardVerificationValue
     * @return $this
     */
    public function setCreditcardVerificationValue($creditcardVerificationValue);

    /**
     * @return string
     */
    public function getCreditcardMonth();

    /**
     * @param string $creditcardMonth
     * @return $this
     */
    public function setCreditcardMonth($creditcardMonth);

    /**
     * @return string
     */
    public function getCreditcardYear();

    /**
     * @param string $creditcardYear
     * @return $this
     */
    public function setCreditcardYear($creditcardYear);

    /**
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function getBillingAddress();

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $billingAddress
     * @return $this
     */
    public function setBillingAddress(AddressInterface $billingAddress);

    /**
     * @return string
     */
    public function getGateway();

    /**
     * @return string|null
     */
    public function getPaymentMethodType();

    /**
     * @return string|null
     */
    public function getPaymentToken();

    /**
     * @return string|null
     */
    public function getPaymentVault();

    /**
     * @return string|null
     */
    public function getThirdPartyVaultType();

    /**
     * @param string $thirdPartyVaultType
     * @return $this
     */
    public function setThirdPartyVaultType($thirdPartyVaultType);

    /**
     * @param string $thirdPartyPaymentToken
     * @return $this
     */
    public function setThirdPartyPaymentToken($thirdPartyPaymentToken);

    /**
     * @return string|null
     */
    public function getThirdPartyPaymentToken();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getCreated();

    /**
     * @return string
     */
    public function getUpdated();

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getThirdPartyTokenData();

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getCreateByTokenData();
}
