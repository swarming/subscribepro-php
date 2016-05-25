<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\DataObjectInterface;

interface CustomerInterface extends DataObjectInterface
{
    /**
     * @return string|null
     */
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return string|null
     */
    public function getFirstName();

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName);

    /**
     * @return string|null
     */
    public function getLastName();

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName);

    /**
     * @return string|null
     */
    public function getMiddleName();

    /**
     * @param string $middleName|null
     * @return $this
     */
    public function setMiddleName($middleName);

    /**
     * @return int|null
     */
    public function getMagentoCustomerId();

    /**
     * @param int $magentoCustomerId|null
     * @return $this
     */
    public function setMagentoCustomerId($magentoCustomerId);

    /**
     * @return int|null
     */
    public function getMagentoCustomerGroupId();

    /**
     * @param int $magentoCustomerGroupId|null
     * @return $this
     */
    public function setMagentoCustomerGroupId($magentoCustomerGroupId);

    /**
     * @return int|null
     */
    public function getMagentoWebsiteId();

    /**
     * @param int $magentoWebsiteId|null
     * @return $this
     */
    public function setMagentoWebsiteId($magentoWebsiteId);

    /**
     * @return bool
     */
    public function getCreateMagentoCustomer();

    /**
     * @param bool $createMagentoCustomer
     * @return $this
     */
    public function setCreateMagentoCustomer($createMagentoCustomer);

    /**
     * @return string|null
     */
    public function getExternalVaultCustomerToken();

    /**
     * @param string $externalVaultCustomerToken|null
     * @return $this
     */
    public function setExternalVaultCustomerToken($externalVaultCustomerToken);

    /**
     * @return int|null
     */
    public function getActiveSubscriptionCount();

    /**
     * @return int|null
     */
    public function getSubscriptionCount();

    /**
     * @return int|null
     */
    public function getActiveSubscribedQty();

    /**
     * @return string|null
     */
    public function getCreated();

    /**
     * @return string|null
     */
    public function getUpdated();
}
