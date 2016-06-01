<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\DataObject;
use \SubscribePro\Service\Address\AddressInterface;

class PaymentProfile extends DataObject implements PaymentProfileInterface
{
    /**
     * @var string
     */
    protected $idField = self::ID;

    /**
     * @var array
     */
    protected $creatingFields = [
        self::CUSTOMER_ID => false,
        self::MAGENTO_CUSTOMER_ID => false,
        self::CREDITCARD_NUMBER => true,
        self::CREDITCARD_VERIFICATION_VALUE => false,
        self::CREDITCARD_MONTH => true,
        self::CREDITCARD_YEAR => true,
        self::BILLING_ADDRESS => true
    ];

    /**
     * @var array
     */
    protected $creatingThirdPartyTokenFields = [
        self::CUSTOMER_ID => true,
        self::THIRD_PARTY_PAYMENT_TOKEN => true,
        self::THIRD_PARTY_VAULT_TYPE => false,
        self::CREDITCARD_TYPE => false,
        self::CREDITCARD_LAST_DIGITS => false,
        self::CREDITCARD_FIRST_DIGITS => false,
        self::CREDITCARD_MONTH => false,
        self::CREDITCARD_YEAR => false,
        self::BILLING_ADDRESS => true
    ];

    /**
     * @var array
     */
    protected $updatingFields = [
        self::CREDITCARD_MONTH => false,
        self::CREDITCARD_YEAR => false,
        self::BILLING_ADDRESS => false
    ];

    /**
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();

        $data[self::BILLING_ADDRESS] = $this->getBillingAddress()->toArray();

        return $data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function importData(array $data = [])
    {
        if (!isset($data[self::BILLING_ADDRESS]) || !$data[self::BILLING_ADDRESS] instanceof AddressInterface) {
            $billingAddressData = isset($data[self::BILLING_ADDRESS]) && is_array($data[self::BILLING_ADDRESS]) ? $data[self::BILLING_ADDRESS] : [];
            $data[self::BILLING_ADDRESS] = $this->getBillingAddress()->importData($billingAddressData);
        }
            
        return parent::importData($data);
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getFormData()
    {
        $formData = parent::getFormData();
        $formData[self::BILLING_ADDRESS] = $this->getBillingAddress()->getBillingAddressFormData();
        return $formData;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return ($this->getCustomerId() || $this->getMagentoCustomerId())
            && parent::isValid()
            && $this->getBillingAddress()->isBillingAddressValid();
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getThirdPartyTokenFormData()
    {
        if (!$this->isThirdPartyDataValid()) {
            throw new \InvalidArgumentException("Not all required fields are set.");
        }

        return array_intersect_key($this->data, $this->creatingThirdPartyTokenFields);
    }

    /**
     * @return bool
     */
    public function isThirdPartyDataValid()
    {
        foreach ($this->creatingThirdPartyTokenFields as $field => $isRequired) {
            if ($isRequired && null === $this->getData($field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getTokenFormData()
    {
        if (!$this->isTokenDataValid()) {
            throw new \InvalidArgumentException("Not all required fields are set.");
        }

        return $this->toArray();
    }

    /**
     * @return bool
     */
    public function isTokenDataValid()
    {
        foreach ($this->updatingFields as $field => $isRequired) {
            if ($isRequired && null === $this->getData($field)) {
                return false;
            }
        }

        return $this->getCustomerId() || $this->getMagentoCustomerId();
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param string $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @return string|null
     */
    public function getMagentoCustomerId()
    {
        return $this->getData(self::MAGENTO_CUSTOMER_ID);
    }

    /**
     * @param string $magentoCustomerId
     * @return $this
     */
    public function setMagentoCustomerId($magentoCustomerId)
    {
        return $this->setData(self::MAGENTO_CUSTOMER_ID, $magentoCustomerId);
    }

    /**
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * @return string|null
     */
    public function getCreditcardType()
    {
        return $this->getData(self::CREDITCARD_TYPE);
    }

    /**
     * @return string
     */
    public function getCreditcardNumber()
    {
        return $this->getData(self::CREDITCARD_NUMBER);
    }

    /**
     * @param string $creditcardNumber
     * @return $this
     */
    public function setCreditcardNumber($creditcardNumber)
    {
        return $this->setData(self::CREDITCARD_NUMBER, $creditcardNumber);
    }

    /**
     * @return string
     */
    public function getCreditcardFirstDigits()
    {
        return $this->getData(self::CREDITCARD_FIRST_DIGITS);
    }

    /**
     * @param string $creditcardFirstDigits
     * @return $this
     */
    public function setCreditcardFirstDigits($creditcardFirstDigits)
    {
        return $this->setData(self::CREDITCARD_FIRST_DIGITS, $creditcardFirstDigits);
    }

    /**
     * @return string
     */
    public function getCreditcardLastDigits()
    {
        return $this->getData(self::CREDITCARD_LAST_DIGITS);
    }

    /**
     * @param string $creditcardLastDigits
     * @return $this
     */
    public function setCreditcardLastDigits($creditcardLastDigits)
    {
        return $this->setData(self::CREDITCARD_LAST_DIGITS, $creditcardLastDigits);
    }

    /**
     * @return string|null
     */
    public function getCreditcardVerificationValue()
    {
        return $this->getData(self::CREDITCARD_VERIFICATION_VALUE);
    }

    /**
     * @param string $creditcardVerificationValue
     * @return $this
     */
    public function setCreditcardVerificationValue($creditcardVerificationValue)
    {
        return $this->setData(self::CREDITCARD_VERIFICATION_VALUE, $creditcardVerificationValue);
    }

    /**
     * @return string
     */
    public function getCreditcardMonth()
    {
        return $this->getData(self::CREDITCARD_MONTH);
    }

    /**
     * @param string $creditcardMonth
     * @return $this
     */
    public function setCreditcardMonth($creditcardMonth)
    {
        return $this->setData(self::CREDITCARD_MONTH, $creditcardMonth);
    }

    /**
     * @return string
     */
    public function getCreditcardYear()
    {
        return $this->getData(self::CREDITCARD_YEAR);
    }

    /**
     * @param string $creditcardYear
     * @return $this
     */
    public function setCreditcardYear($creditcardYear)
    {
        return $this->setData(self::CREDITCARD_YEAR, $creditcardYear);
    }

    /**
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function getBillingAddress()
    {
        return $this->getData(self::BILLING_ADDRESS);
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $billingAddress
     * @return $this
     */
    public function setBillingAddress(AddressInterface $billingAddress)
    {
        return $this->setData(self::BILLING_ADDRESS, $billingAddress);
    }

    /**
     * @return string
     */
    public function getGateway()
    {
        return $this->getData(self::GATEWAY);
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodType()
    {
        return $this->getData(self::PAYMENT_METHOD_TYPE);
    }

    /**
     * @return string|null
     */
    public function getPaymentToken()
    {
        return $this->getData(self::PAYMENT_TOKEN);
    }

    /**
     * @return string|null
     */
    public function getPaymentVault()
    {
        return $this->getData(self::PAYMENT_VAULT);
    }

    /**
     * @return string|null
     */
    public function getThirdPartyVaultType()
    {
        return $this->getData(self::THIRD_PARTY_VAULT_TYPE);
    }

    /**
     * @param string $thirdPartyVaultType
     * @return $this
     */
    public function setThirdPartyVaultType($thirdPartyVaultType)
    {
        return $this->setData(self::THIRD_PARTY_VAULT_TYPE, $thirdPartyVaultType);
    }

    /**
     * @return string|null
     */
    public function getThirdPartyPaymentToken()
    {
        return $this->getData(self::THIRD_PARTY_PAYMENT_TOKEN);
    }

    /**
     * @param string $thirdPartyPaymentToken
     * @return $this
     */
    public function setThirdPartyPaymentToken($thirdPartyPaymentToken)
    {
        return $this->setData(self::THIRD_PARTY_PAYMENT_TOKEN, $thirdPartyPaymentToken);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->getData(self::CREATED);
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return $this->getData(self::UPDATED);
    }
}
