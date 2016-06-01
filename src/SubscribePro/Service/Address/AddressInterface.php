<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\DataInterface;

interface AddressInterface extends DataInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const MAGENTO_ADDRESS_ID = 'magento_address_id';
    const FIRST_NAME = 'first_name';
    const MIDDLE_NAME = 'middle_name';
    const LAST_NAME = 'last_name';
    const COMPANY = 'company';
    const STREET1 = 'street1';
    const STREET2 = 'street2';
    const CITY = 'city';
    const REGION = 'region';
    const POSTCODE = 'postcode';
    const COUNTRY = 'country';
    const PHONE = 'phone';
    const CREATED = 'created';
    const UPDATED = 'updated';

    /**
     * @return bool
     */
    public function isBillingAddressValid();

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getBillingAddressFormData();

    /**
     * @return bool
     */
    public function isUpdateDataValid();

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getUpdateData();
    
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
     * @param string|null $middleName
     * @return $this
     */
    public function setMiddleName($middleName);

    /**
     * @return string|null
     */
    public function getMagentoAddressId();

    /**
     * @return string|null
     */
    public function getCompany();

    /**
     * @param string|null $company
     * @return $this
     */
    public function setCompany($company);

    /**
     * @return string|null
     */
    public function getStreet1();

    /**
     * @param string|null $street1
     * @return $this
     */
    public function setStreet1($street1);

    /**
     * @return string|null
     */
    public function getStreet2();

    /**
     * @param string|null $street2
     * @return $this
     */
    public function setStreet2($street2);

    /**
     * @return string|null
     */
    public function getCity();

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * @return string|null
     */
    public function getRegion();

    /**
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * @return string|null
     */
    public function getPostCode();

    /**
     * @param string $postCode
     * @return $this
     */
    public function setPostCode($postCode);

    /**
     * @return string|null
     */
    public function getCountry();

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($country);

    /**
     * @return string|null
     */
    public function getPhone();

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone);

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getCreated($format = null);

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getUpdated($format = null);
}
