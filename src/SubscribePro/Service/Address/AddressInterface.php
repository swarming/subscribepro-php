<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\DataObjectInterface;

interface AddressInterface extends DataObjectInterface
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
     * @param string $middleName|null
     * @return $this
     */
    public function setMiddleName($middleName);

    /**
     * @return string|null
     */
    public function getMagentoAddressId();

    /**
     * @param string $magentoAddressId|null
     * @return $this
     */
    public function setMagentoAddressId($magentoAddressId);

    /**
     * @return string|null
     */
    public function getCompany();

    /**
     * @param string $company|null
     * @return $this
     */
    public function setCompany($company);

    /**
     * @return string|null
     */
    public function getStreet1();

    /**
     * @param string $street1|null
     * @return $this
     */
    public function setStreet1($street1);

    /**
     * @return string|null
     */
    public function getStreet2();

    /**
     * @param string $street2|null
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
     * @return string|null
     */
    public function getCreated();

    /**
     * @return string|null
     */
    public function getUpdated();
}
