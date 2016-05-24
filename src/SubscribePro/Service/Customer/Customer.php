<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\DataObject;

class Customer extends DataObject
{
    const ID = 'id';
    const EMAIL = 'email';
    const MAGENTO_CUSTOMER_ID = 'magento_customer_id';
    const MAGENTO_CUSTOMER_GROUP_ID = 'magento_customer_group_id';
    const MAGENTO_WEBSITE_ID = 'magento_website_id';
    const CREATE_MAGENTO_CUSTOMER = 'create_magento_customer';
    const EXTERNAL_VAULT_CUSTOMER_TOKEN = 'external_vault_customer_token';
    const FIRST_NAME = 'first_name';
    const MIDDLE_NAME = 'middle_name';
    const LAST_NAME = 'last_name';
    const FULL_NAME = 'full_name';
    const ACTIVE_SUBSCRIPTION_COUNT = 'active_subscription_count';
    const SUBSCRIPTION_COUNT = 'subscription_count';
    const ACTIVE_SUBSCRIBED_QTY = 'active_subscribed_qty';
    const CREATED = 'created';
    const UPDATED = 'updated';

    /**
     * @var string
     */
    protected $idField = self::ID;

    /**
     * @var array
     */
    protected $nonUpdatableFields = [
        self::ID,
        self::FULL_NAME,
        self::ACTIVE_SUBSCRIBED_QTY,
        self::ACTIVE_SUBSCRIPTION_COUNT,
        self::SUBSCRIPTION_COUNT,
        self::CREATED,
        self::UPDATED
    ];

    /**
     * @var array
     */
    protected $requiredFields = [
        self::EMAIL,
        self::FIRST_NAME,
        self::LAST_NAME
    ];

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->getData(self::FIRST_NAME);
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        return $this->setData(self::FIRST_NAME, $firstName);
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->getData(self::FIRST_NAME);
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        return $this->setData(self::LAST_NAME, $lastName);
    }

    /**
     * @return string|null
     */
    public function getMiddleName()
    {
        return $this->getData(self::MIDDLE_NAME);
    }

    /**
     * @param string $middleName|null
     * @return $this
     */
    public function setMiddleName($middleName)
    {
        return $this->setData(self::MIDDLE_NAME, $middleName);
    }

    /**
     * @return int|null
     */
    public function getMagentoCustomerId()
    {
        return $this->getData(self::MAGENTO_CUSTOMER_ID);
    }

    /**
     * @param int $magentoCustomerId|null
     * @return $this
     */
    public function setMagentoCustomerId($magentoCustomerId)
    {
        return $this->setData(self::MAGENTO_CUSTOMER_ID, $magentoCustomerId);
    }

    /**
     * @return int|null
     */
    public function getMagentoCustomerGroupId()
    {
        return $this->getData(self::MAGENTO_CUSTOMER_GROUP_ID);
    }

    /**
     * @param int $magentoCustomerGroupId|null
     * @return $this
     */
    public function setMagentoCustomerGroupId($magentoCustomerGroupId)
    {
        return $this->setData(self::MAGENTO_CUSTOMER_GROUP_ID, $magentoCustomerGroupId);
    }

    /**
     * @return int|null
     */
    public function getMagentoWebsiteId()
    {
        return $this->getData(self::MAGENTO_WEBSITE_ID);
    }

    /**
     * @param int $magentoWebsiteId|null
     * @return $this
     */
    public function setMagentoWebsiteId($magentoWebsiteId)
    {
        return $this->setData(self::MAGENTO_WEBSITE_ID, $magentoWebsiteId);
    }


    /**
     * @return bool
     */
    public function getCreateMagentoCustomer()
    {
        return $this->getData(self::CREATE_MAGENTO_CUSTOMER);
    }

    /**
     * @param bool $createMagentoCustomer
     * @return $this
     */
    public function setCreateMagentoCustomer($createMagentoCustomer)
    {
        return $this->setData(self::CREATE_MAGENTO_CUSTOMER, $createMagentoCustomer);
    }

    /**
     * @return string|null
     */
    public function getExternalVaultCustomerToken()
    {
        return $this->getData(self::EXTERNAL_VAULT_CUSTOMER_TOKEN);
    }

    /**
     * @param string $externalVaultCustomerToken|null
     * @return $this
     */
    public function setExternalVaultCustomerToken($externalVaultCustomerToken)
    {
        return $this->setData(self::EXTERNAL_VAULT_CUSTOMER_TOKEN, $externalVaultCustomerToken);
    }

    /**
     * @return int|null
     */
    public function getActiveSubscriptionCount()
    {
        return $this->getData(self::ACTIVE_SUBSCRIPTION_COUNT);
    }

    /**
     * @return int|null
     */
    public function getSubscriptionCount()
    {
        return $this->getData(self::SUBSCRIPTION_COUNT);
    }

    /**
     * @return int|null
     */
    public function getActiveSubscribedQty()
    {
        return $this->getData(self::ACTIVE_SUBSCRIBED_QTY);
    }

    /**
     * @return string|null
     */
    public function getCreated()
    {
        return $this->getData(self::CREATED);
    }

    /**
     * @return string|null
     */
    public function getUpdated()
    {
        return $this->getData(self::UPDATED);
    }
}
