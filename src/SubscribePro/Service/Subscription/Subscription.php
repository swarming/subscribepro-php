<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\DataObject;
use SubscribePro\Service\Address\AddressInterface;
use SubscribePro\Service\PaymentProfile\PaymentProfileInterface;

class Subscription extends DataObject implements SubscriptionInterface
{
    /**
     * @var string
     */
    protected $idField = self::ID;

    /**
     * @var array
     */
    protected $creatingFields = [
        self::CUSTOMER_ID => true,
        self::PAYMENT_PROFILE_ID => true,
        self::SHIPPING_ADDRESS_ID => false,
        self::SHIPPING_ADDRESS => false,
        self::PRODUCT_SKU => true,
        self::QTY => true,
        self::USE_FIXED_PRICE => true,
        self::FIXED_PRICE => false,
        self::INTERVAL => false,
        self::NEXT_ORDER_DATE => true,
        self::FIRST_ORDER_ALREADY_CREATED => false,
        self::SEND_CUSTOMER_NOTIFICATION_EMAIL => false,
        self::EXPIRATION_DATE => false,
        self::COUPON_CODE => false,
        self::MAGENTO_STORE_CODE => false,
        self::MAGENTO_SHIPPING_METHOD_CODE => true,
        self::USER_DEFINED_FIELDS => false
    ];

    /**
     * @var array
     */
    protected $updatingFields = [
        self::PAYMENT_PROFILE_ID => true,
        self::SHIPPING_ADDRESS_ID => false,
        self::SHIPPING_ADDRESS => false,
        self::PRODUCT_SKU => true,
        self::QTY => true,
        self::USE_FIXED_PRICE => true,
        self::FIXED_PRICE => false, // true
        self::INTERVAL => true,
        self::NEXT_ORDER_DATE => true,
        self::SEND_CUSTOMER_NOTIFICATION_EMAIL => false,
        self::EXPIRATION_DATE => false,
        self::COUPON_CODE => false,
        self::MAGENTO_STORE_CODE => false,
        self::MAGENTO_SHIPPING_METHOD_CODE => true,
        self::USER_DEFINED_FIELDS => false
    ];

    /**
     * @var array
     */
    protected $eitherFieldRequired = [
        [self::SHIPPING_ADDRESS_ID, self::SHIPPING_ADDRESS]
    ];

    /**
     * @param array $data
     * @return $this
     */
    public function importData(array $data = [])
    {
        if (!empty($data[self::SHIPPING_ADDRESS]) && $data[self::SHIPPING_ADDRESS] instanceof AddressInterface) {
            $data[self::SHIPPING_ADDRESS_ID] = $data[self::SHIPPING_ADDRESS]->getId();
        }

        if (!empty($data[self::PAYMENT_PROFILE]) && $data[self::PAYMENT_PROFILE] instanceof PaymentProfileInterface) {
            $data[self::PAYMENT_PROFILE_ID] = $data[self::SHIPPING_ADDRESS]->getId();
        }

        return parent::importData($data);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();

        $data[self::PAYMENT_PROFILE] = $this->getPaymentProfile()->toArray();
        $data[self::SHIPPING_ADDRESS] = $this->getShippingAddress()->toArray();

        return $data;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getFormData()
    {
        $formData = parent::getFormData();

        $formData[self::PAYMENT_PROFILE] = $this->getPaymentProfile()->getFormData();
        $formData[self::SHIPPING_ADDRESS] = $this->getShippingAddress()->getFormData();

        foreach ($this->eitherFieldRequired as $pair) {
            if (empty($formData[$pair[0]])) {
                unset($formData[$pair[0]]);
            } else {
                unset($formData[$pair[1]]);
            }
        }

        return $formData;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->eitherFieldRequired as $pair) {
            if ($this->getData($pair[0], false) == false && $this->getData($pair[1], false) == false) {
                return false;
            }
        }

        return parent::isValid()
            && $this->getPaymentProfile()->isValid()
            && $this->getShippingAddress()->isValid();
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
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return string|null
     */
    public function getProductSku()
    {
        return $this->getData(self::PRODUCT_SKU);
    }

    /**
     * @param string $productSku
     * @return $this
     */
    public function setProductSku($productSku)
    {
        return $this->setData(self::PRODUCT_SKU, $productSku);
    }

    /**
     * @return float|null
     */
    public function getQty()
    {
        return $this->getData(self::QTY);
    }

    /**
     * @param float $qty
     * @return $this
     */
    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }

    /**
     * @return bool|null
     */
    public function getUseFixedPrice()
    {
        return $this->getData(self::USE_FIXED_PRICE);
    }

    /**
     * @param bool $useFixedPrice
     * @return $this
     */
    public function setUseFixedPrice($useFixedPrice)
    {
        return $this->setData(self::USE_FIXED_PRICE, $useFixedPrice);
    }

    /**
     * @return float|null
     */
    public function getFixedPrice()
    {
        return $this->getData(self::FIXED_PRICE);
    }

    /**
     * @param float $fixedPrice
     * @return $this
     */
    public function setFixedPrice($fixedPrice)
    {
        return $this->setData(self::FIXED_PRICE, $fixedPrice);
    }

    /**
     * @return string|null
     */
    public function getInterval()
    {
        return $this->getData(self::INTERVAL);
    }

    /**
     * @param string $interval
     * @return $this
     */
    public function setInterval($interval)
    {
        return $this->setData(self::INTERVAL, $interval);
    }

    /**
     * @return string|null
     */
    public function getMagentoStoreCode()
    {
        return $this->getData(self::MAGENTO_STORE_CODE);
    }

    /**
     * @param string $magentoStoreCode
     * @return $this
     */
    public function setMagentoStoreCode($magentoStoreCode)
    {
        return $this->setData(self::MAGENTO_STORE_CODE, $magentoStoreCode);
    }

    /**
     * @return int|null
     */
    public function getPaymentProfileId()
    {
        return $this->getData(self::PAYMENT_PROFILE_ID);
    }

    /**
     * @param int $paymentProfileId
     * @return $this
     */
    public function setPaymentProfileId($paymentProfileId)
    {
        return $this->setData(self::PAYMENT_PROFILE_ID, $paymentProfileId);
    }

    /**
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function getPaymentProfile()
    {
        return $this->getData(self::PAYMENT_PROFILE);
    }

    /**
     * @param \SubscribePro\Service\PaymentProfile\PaymentProfileInterface $paymentProfile
     * @return $this
     */
    public function setPaymentProfile(PaymentProfileInterface $paymentProfile)
    {
        return $this->setData(self::PAYMENT_PROFILE, $paymentProfile);
    }

    /**
     * @return int|null
     */
    public function getShippingAddressId()
    {
        return $this->getData(self::SHIPPING_ADDRESS_ID);
    }

    /**
     * @param int $shippingAddressId
     * @return $this
     */
    public function setShippingAddressId($shippingAddressId)
    {
        return $this->setData(self::SHIPPING_ADDRESS_ID, $shippingAddressId);
    }

    /**
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function getShippingAddress()
    {
        return $this->getData(self::SHIPPING_ADDRESS);
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $shippingAddress
     * @return $this
     */
    public function setShippingAddress(AddressInterface $shippingAddress)
    {
        return $this->setData(self::SHIPPING_ADDRESS, $shippingAddress);
    }

    /**
     * @return string|null
     */
    public function getMagentoShippingMethodCode()
    {
        return $this->getData(self::MAGENTO_SHIPPING_METHOD_CODE);
    }

    /**
     * @param string $magentoShippingMethodCode
     * @return $this
     */
    public function setMagentoShippingMethodCode($magentoShippingMethodCode)
    {
        return $this->setData(self::MAGENTO_SHIPPING_METHOD_CODE, $magentoShippingMethodCode);
    }

    /**
     * @return bool|null
     */
    public function getSendCustomerNotificationEmail()
    {
        return $this->getData(self::SEND_CUSTOMER_NOTIFICATION_EMAIL);
    }

    /**
     * @param bool $sendCustomerNotificationEmail
     * @return $this
     */
    public function setSendCustomerNotificationEmail($sendCustomerNotificationEmail)
    {
        return $this->setData(self::SEND_CUSTOMER_NOTIFICATION_EMAIL, $sendCustomerNotificationEmail);
    }

    /**
     * @return bool|null
     */
    public function getFirstOrderAlreadyCreated()
    {
        return $this->getData(self::FIRST_ORDER_ALREADY_CREATED);
    }

    /**
     * @param bool $firstOrderAlreadyCreated
     * @return $this
     */
    public function setFirstOrderAlreadyCreated($firstOrderAlreadyCreated)
    {
        return $this->setData(self::FIRST_ORDER_ALREADY_CREATED, $firstOrderAlreadyCreated);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getNextOrderDate($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::NEXT_ORDER_DATE), $format, 'Y-m-d');
    }

    /**
     * @param string $nextOrderDate
     * @return $this
     */
    public function setNextOrderDate($nextOrderDate)
    {
        return $this->setData(self::NEXT_ORDER_DATE, $nextOrderDate);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getLastOrderDate($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::LAST_ORDER_DATE), $format);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getExpirationDate($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::EXPIRATION_DATE), $format, 'Y-m-d');
    }

    /**
     * @param string $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        return $this->setData(self::EXPIRATION_DATE, $expirationDate);
    }

    /**
     * @return string|null
     */
    public function getCouponCode()
    {
        return $this->getData(self::COUPON_CODE);
    }

    /**
     * @param string $couponCode
     * @return $this
     */
    public function setCouponCode($couponCode)
    {
        return $this->setData(self::COUPON_CODE, $couponCode);
    }

    /**
     * @return array
     */
    public function getUserDefinedFields()
    {
        return $this->getData(self::USER_DEFINED_FIELDS, []);
    }

    /**
     * @param array $userDefinedFields
     * @return $this
     */
    public function setUserDefinedFields(array $userDefinedFields)
    {
        return $this->setData(self::USER_DEFINED_FIELDS, $userDefinedFields);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getErrorTime($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::ERROR_TIME), $format); /* TODO find out date format of this field  */
    }

    /**
     * @return string|null
     */
    public function getErrorClass()
    {
        return $this->getData(self::ERROR_CLASS);
    }

    /**
     * @return string|null
     */
    public function getErrorClassDescription()
    {
        return $this->getData(self::ERROR_CLASS_DESCRIPTION);
    }

    /**
     * @return string|null
     */
    public function getErrorType()
    {
        return $this->getData(self::ERROR_TYPE);
    }

    /**
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->getData(self::ERROR_MESSAGE);
    }

    /**
     * @return int|null
     */
    public function getFailedOrderAttemptCount()
    {
        return $this->getData(self::FAILED_ORDER_ATTEMPT_COUNT);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getRetryAfter($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::RETRY_AFTER), $format); /* TODO find out date format of this field  */
    }

    /**
     * @return int|null
     */
    public function getRecurringOrderCount()
    {
        return $this->getData(self::RECURRING_ORDER_COUNT);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getCreated($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::CREATED), $format);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getUpdated($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::UPDATED), $format);
    }

    /**
     * @param null|string $format
     * @return string|null
     */
    public function getCancelled($format = null)
    {
        return \SubscribePro\formatDate($this->getData(self::CANCELLED), $format);
    }
}
