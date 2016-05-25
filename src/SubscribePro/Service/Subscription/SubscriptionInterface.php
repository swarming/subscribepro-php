<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\DataObjectInterface;

interface SubscriptionInterface extends DataObjectInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const STATUS = 'status';
    const PRODUCT_SKU = 'product_sku';
    const QTY = 'qty';
    const USE_FIXED_PRICE = 'use_fixed_price';
    const FIXED_PRICE = 'fixed_price';
    const INTERVAL = 'interval';
    const MAGENTO_STORE_CODE = 'magento_store_code';
    const PAYMENT_PROFILE_ID = 'payment_profile_id';
    const PAYMENT_PROFILE = 'payment_profile';
    const SHIPPING_ADDRESS_ID = 'shipping_address_id';
    const SHIPPING_ADDRESS = 'shipping_address';
    const MAGENTO_SHIPPING_METHOD_CODE = 'magento_shipping_method_code';
    const SEND_CUSTOMER_NOTIFICATION_EMAIL = 'send_customer_notification_email';
    const FIRST_ORDER_ALREADY_CREATED = 'first_order_already_created';
    const NEXT_ORDER_DATE = 'next_order_date';
    const LAST_ORDER_DATE = 'last_order_date';
    const EXPIRATION_DATE = 'expiration_date';
    const COUPON_CODE = 'coupon_code';
    const USER_DEFINED_FIELDS = 'user_defined_fields';
    const RECURRING_ORDER_COUNT = 'recurring_order_count';
    const ERROR_TIME = 'error_time';
    const ERROR_CLASS = 'error_class';
    const ERROR_CLASS_DESCRIPTION = 'error_class_description';
    const ERROR_TYPE = 'error_type';
    const ERROR_MESSAGE = 'error_message';
    const FAILED_ORDER_ATTEMPT_COUNT = 'failed_order_attempt_count';
    const RETRY_AFTER = 'retry_after';
    const CREATED = 'created';
    const UPDATED = 'updated';
    const CANCELLED = 'cancelled';

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
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string|null
     */
    public function getProductSku();

    /**
     * @param string $productSku
     * @return $this
     */
    public function setProductSku($productSku);

    /**
     * @return float|null
     */
    public function getQty();

    /**
     * @param float $qty
     * @return $this
     */
    public function setQty($qty);

    /**
     * @return bool|null
     */
    public function getUseFixedPrice();

    /**
     * @param bool $useFixedPrice
     * @return $this
     */
    public function setUseFixedPrice($useFixedPrice);

    /**
     * @return float|null
     */
    public function getFixedPrice();

    /**
     * @param float $fixedPrice
     * @return $this
     */
    public function setFixedPrice($fixedPrice);

    /**
     * @return string|null
     */
    public function getInterval();

    /**
     * @param string $interval
     * @return $this
     */
    public function setInterval($interval);

    /**
     * @return string|null
     */
    public function getMagentoStoreCode();

    /**
     * @param string $magentoStoreCode
     * @return $this
     */
    public function setMagentoStoreCode($magentoStoreCode);

    /**
     * @return int|null
     */
    public function getPaymentProfileId();

    /**
     * @param int $paymentProfileId
     * @return $this
     */
    public function setPaymentProfileId($paymentProfileId);

    /**
     * @return array
     */
    public function getPaymentProfile();

    /**
     * @param array $paymentProfile
     * @return $this
     */
    public function setPaymentProfile($paymentProfile);

    /**
     * @return int|null
     */
    public function getShippingAddressId();

    /**
     * @param int $shippingAddressId
     * @return $this
     */
    public function setShippingAddressId($shippingAddressId);

    /**
     * @return array
     */
    public function getShippingAddress();

    /**
     * @param array $shippingAddress
     * @return $this
     */
    public function setShippingAddress($shippingAddress);

    /**
     * @return string|null
     */
    public function getMagentoShippingMethodCode();

    /**
     * @param string $magentoShippingMethodCode
     * @return $this
     */
    public function setMagentoShippingMethodCode($magentoShippingMethodCode);

    /**
     * @return bool|null
     */
    public function getSendCustomerNotificationEmail();

    /**
     * @param bool $sendCustomerNotificationEmail
     * @return $this
     */
    public function setSendCustomerNotificationEmail($sendCustomerNotificationEmail);

    /**
     * @return bool|null
     */
    public function getFirstOrderAlreadyCreated();

    /**
     * @param bool $firstOrderAlreadyCreated
     * @return $this
     */
    public function setFirstOrderAlreadyCreated($firstOrderAlreadyCreated);

    /**
     * @return string|null
     */
    public function getNextOrderDate();

    /**
     * @param string $nextOrderDate
     * @return $this
     */
    public function setNextOrderDate($nextOrderDate);

    /**
     * @return string|null
     */
    public function getLastOrderDate();

    /**
     * @return string|null
     */
    public function getExpirationDate();

    /**
     * @param string $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate);

    /**
     * @return string|null
     */
    public function getCouponCode();

    /**
     * @param string $couponCode
     * @return $this
     */
    public function setCouponCode($couponCode);

    /**
     * @return array
     */
    public function getUserDefinedFields();

    /**
     * @param array $userDefinedFields
     * @return $this
     */
    public function setUserDefinedFields(array $userDefinedFields);

    /**
     * @return string|null
     */
    public function getErrorTime();

    /**
     * @return string|null
     */
    public function getErrorClass();

    /**
     * @return string|null
     */
    public function getErrorClassDescription();

    /**
     * @return string|null
     */
    public function getErrorType();

    /**
     * @return string|null
     */
    public function getErrorMessage();

    /**
     * @return int|null
     */
    public function getFailedOrderAttemptCount();

    /**
     * @return string|null
     */
    public function getRetryAfter();

    /**
     * @return int|null
     */
    public function getRecurringOrderCount();

    /**
     * @return string|null
     */
    public function getCreated();

    /**
     * @return string|null
     */
    public function getUpdated();

    /**
     * @return string|null
     */
    public function getCancelled();
}
