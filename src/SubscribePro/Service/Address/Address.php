<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\DataObject;

class Address extends DataObject implements AddressInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const MAGENTO_ADDRESS_ID = 'magento_address_id';
    const COMPANY = 'company';
    const STREET1 = 'street1';
    const STREET2 = 'street2';
    const CITY = 'city';
    const REGION = 'region';
    const POSTCODE = 'postcode';
    const PHONE = 'phone';
    const COUNTRY = 'country';
    const FIRST_NAME = 'first_name';
    const MIDDLE_NAME = 'middle_name';
    const LAST_NAME = 'last_name';
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
        self::CUSTOMER_ID,
        self::CREATED,
        self::UPDATED
    ];

    /**
     * @var array
     */
    protected $nonCreatableFields = [
        self::ID,
        self::CREATED,
        self::UPDATED
    ];

    /**
     * @var array
     */
    protected $requiredFields = [
        self::CUSTOMER_ID,
        self::FIRST_NAME,
        self::LAST_NAME
    ];

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->getId() ? true : parent::isValid();
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
        return $this->getData(self::LAST_NAME);
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
     * @return string|null
     */
    public function getMagentoAddressId()
    {
        return $this->getData(self::MAGENTO_ADDRESS_ID);
    }

    /**
     * @param string $magentoAddressId|null
     * @return $this
     */
    public function setMagentoAddressId($magentoAddressId)
    {
        return $this->setData(self::MAGENTO_ADDRESS_ID, $magentoAddressId);
    }

    /**
     * @return string|null
     */
    public function getCompany()
    {
        return $this->getData(self::COMPANY);
    }

    /**
     * @param string $company|null
     * @return $this
     */
    public function setCompany($company)
    {
        return $this->setData(self::COMPANY, $company);
    }

    /**
     * @return string|null
     */
    public function getStreet1()
    {
        return $this->getData(self::STREET1);
    }

    /**
     * @param string $street1|null
     * @return $this
     */
    public function setStreet1($street1)
    {
        return $this->setData(self::STREET1, $street1);
    }

    /**
     * @return string|null
     */
    public function getStreet2()
    {
        return $this->getData(self::STREET2);
    }

    /**
     * @param string $street2|null
     * @return $this
     */
    public function setStreet2($street2)
    {
        return $this->setData(self::STREET2, $street2);
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @return string|null
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * @return string|null
     */
    public function getPostCode()
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * @param string $postCode
     * @return $this
     */
    public function setPostCode($postCode)
    {
        return $this->setData(self::POSTCODE, $postCode);
    }

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * @return string|null
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
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

    /**
     * @param bool $changedOnly
     * @return array
     */
    public function getFormData($changedOnly = true)
    {
        if (!$this->getData($this->idField)) {
            return array_diff_key($this->data, array_flip($this->nonCreatableFields));
        }
        
        $data = $changedOnly ? $this->changes : $this->data;
        return array_diff_key($data, array_flip($this->nonUpdatableFields));
    }
}
