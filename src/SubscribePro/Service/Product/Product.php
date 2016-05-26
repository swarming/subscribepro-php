<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\DataObject;

class Product extends DataObject implements ProductInterface
{
    /**
     * @var string
     */
    protected $idField = self::ID;

    /**
     * @var array
     */
    protected $creatingFields = [
        self::SKU => true,
        self::NAME => true,
        self::PRICE => true,
        self::SHOW_ON_UI => false,
        self::MIN_QTY => false,
        self::MAX_QTY => false,
        self::DISCOUNT => false,
        self::IS_DISCOUNT_PERCENTAGE => false,
//        self::SUBSCRIPTION_OPTION_MODE => false, /* TODO find out whether we can use this field for POST  */
//        self::DEFAULT_SUBSCRIPTION_OPTION => false, /* TODO find out whether we can use this field for POST  */
        self::DEFAULT_INTERVAL => false,
        self::INTERVALS => false,
//        self::IS_TRIAL_PRODUCT => false, /* TODO find out whether we can use this field for POST  */
        self::TRIAL_INTERVAL => false,
        self::TRIAL_PRICE => false,
        self::TRIAL_FULL_PRODUCT_SKU => false,
        self::TRIAL_EMAIL_TEMPLATE_CODE => false,
        self::TRIAL_EMAIL_THRESHOLD_DAYS => false,
        self::TRIAL_WELCOME_EMAIL_TEMPLATE_CODE => false
    ];

    /**
     * @var array
     */
    protected $updatingFields = [
        self::SKU => false,
        self::NAME => false,
        self::PRICE => false,
        self::SHOW_ON_UI => false,
        self::MIN_QTY => false,
        self::MAX_QTY => false,
        self::DISCOUNT => false,
        self::IS_DISCOUNT_PERCENTAGE => false,
//        self::SUBSCRIPTION_OPTION_MODE => false, /* TODO find out whether we can use this field for POST  */
//        self::DEFAULT_SUBSCRIPTION_OPTION => false, /* TODO find out whether we can use this field for POST  */
        self::DEFAULT_INTERVAL => false,
        self::INTERVALS => false,
//        self::IS_TRIAL_PRODUCT => false, /* TODO find out whether we can use this field for POST  */
        self::TRIAL_INTERVAL => false,
        self::TRIAL_PRICE => false,
        self::TRIAL_FULL_PRODUCT_SKU => false,
        self::TRIAL_EMAIL_TEMPLATE_CODE => false,
        self::TRIAL_EMAIL_THRESHOLD_DAYS => false,
        self::TRIAL_WELCOME_EMAIL_TEMPLATE_CODE => false
    ];

    /**
     * @return string|null
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * @param string|null $sku
     * @return $this
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return bool|null
     */
    public function getShowOnUi()
    {
        return $this->getData(self::SHOW_ON_UI);
    }

    /**
     * @param bool|null $showOnUi
     * @return $this
     */
    public function setShowOnUi($showOnUi)
    {
        return $this->setData(self::SHOW_ON_UI, $showOnUi);
    }

    /**
     * @return float|null
     */
    public function getMinQty()
    {
        return $this->getData(self::MIN_QTY);
    }

    /**
     * @param float|null $minQty
     * @return $this
     */
    public function setMinQty($minQty)
    {
        return $this->setData(self::MIN_QTY, $minQty);
    }

    /**
     * @return float|null
     */
    public function getMaxQty()
    {
        return $this->getData(self::MAX_QTY);
    }

    /**
     * @param float|null $maxQty
     * @return $this
     */
    public function setMaxQty($maxQty)
    {
        return $this->setData(self::MAX_QTY, $maxQty);
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * @param float|null $price
     * @return $this
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @return float|null
     */
    public function getDiscount()
    {
        return $this->getData(self::DISCOUNT);
    }

    /**
     * @param float|null $discount
     * @return $this
     */
    public function setDiscount($discount)
    {
        return $this->getData(self::DISCOUNT, $discount);
    }

    /**
     * @return bool|null
     */
    public function getIsDiscountPercentage()
    {
        return $this->getData(self::IS_DISCOUNT_PERCENTAGE);
    }

    /**
     * @param bool|null $isDiscountPercentage
     * @return $this
     */
    public function setIsDiscountPercentage($isDiscountPercentage)
    {
        return $this->setData(self::IS_DISCOUNT_PERCENTAGE, $isDiscountPercentage);
    }

    /**
     * @return string|null
     */
    public function getSubscriptionOptionMode()
    {
        return $this->getData(self::SUBSCRIPTION_OPTION_MODE);
    }

    /**
     * @param string|null $subscriptionOptionMode
     * @return $this
     */
    public function setSubscriptionOptionMode($subscriptionOptionMode)
    {
        return $this->setData(self::SUBSCRIPTION_OPTION_MODE, $subscriptionOptionMode);
    }

    /**
     * @return string|null
     */
    public function getDefaultSubscriptionOption()
    {
        return $this->getData(self::DEFAULT_SUBSCRIPTION_OPTION);
    }

    /**
     * @param string|null $defaultSubscriptionOption
     * @return $this
     */
    public function setDefaultSubscriptionOption($defaultSubscriptionOption)
    {
        return $this->setData(self::DEFAULT_SUBSCRIPTION_OPTION, $defaultSubscriptionOption);
    }

    /**
     * @return string|null
     */
    public function getDefaultInterval()
    {
        return $this->getData(self::DEFAULT_INTERVAL);
    }

    /**
     * @param string|null $defaultInterval
     * @return $this
     */
    public function setDefaultInterval($defaultInterval)
    {
        return $this->setData(self::DEFAULT_INTERVAL, $defaultInterval);
    }

    /**
     * @return array|null
     */
    public function getIntervals()
    {
        return $this->getData(self::INTERVALS);
    }

    /**
     * @param array|null $intervals
     * @return $this
     */
    public function setIntervals($intervals)
    {
        return $this->setData(self::INTERVALS, $intervals);
    }

    /**
     * @return string|null
     */
    public function getProductOptionsMode()
    {
        return $this->getData(self::PRODUCT_OPTIONS_MODE);
    }

    /**
     * @param string|null $productOptionsMode
     * @return $this
     */
    public function setProductOptionsMode($productOptionsMode)
    {
        return $this->setData(self::PRODUCT_OPTIONS_MODE, $productOptionsMode);
    }

    /**
     * @return bool|null
     */
    public function getIsTrialProduct()
    {
        return $this->getData(self::IS_TRIAL_PRODUCT);
    }

    /**
     * @param bool|null $isTrialProduct
     * @return $this
     */
    public function setIsTrialProduct($isTrialProduct)
    {
        return $this->setData(self::IS_TRIAL_PRODUCT, $isTrialProduct);
    }

    /**
     * @return string|null
     */
    public function getTrialInterval()
    {
        return $this->getData(self::TRIAL_INTERVAL);
    }

    /**
     * @param string|null $trialInterval
     * @return $this
     */
    public function setTrialInterval($trialInterval)
    {
        return $this->setData(self::TRIAL_INTERVAL, $trialInterval);
    }

    /**
     * @return float|null
     */
    public function getTrialPrice()
    {
        return $this->getData(self::TRIAL_PRICE);
    }

    /**
     * @param float|null $trialPrice
     * @return $this
     */
    public function setTrialPrice($trialPrice)
    {
        return $this->setData(self::TRIAL_PRICE, $trialPrice);
    }

    /**
     * @return string|null
     */
    public function getTrialFullProductSku()
    {
        return $this->getData(self::TRIAL_FULL_PRODUCT_SKU);
    }

    /**
     * @param string|null $trialFullProductSku
     * @return $this
     */
    public function setTrialFullProductSku($trialFullProductSku)
    {
        return $this->setData(self::TRIAL_FULL_PRODUCT_SKU, $trialFullProductSku);
    }

    /**
     * @return string|null
     */
    public function getTrialEmailTemplateCode()
    {
        return $this->getData(self::TRIAL_EMAIL_TEMPLATE_CODE);
    }

    /**
     * @param string|null $trialEmailTemplateCode
     * @return $this
     */
    public function setTrialEmailTemplateCode($trialEmailTemplateCode)
    {
        return $this->setData(self::TRIAL_EMAIL_TEMPLATE_CODE, $trialEmailTemplateCode);
    }

    /**
     * @return float|null
     */
    public function getTrialEmailThresholdDays()
    {
        return $this->getData(self::TRIAL_EMAIL_THRESHOLD_DAYS);
    }

    /**
     * @param float|null $trialEmailThresholdDays
     * @return $this
     */
    public function setTrialEmailThresholdDays($trialEmailThresholdDays)
    {
        return $this->setData(self::TRIAL_EMAIL_THRESHOLD_DAYS, $trialEmailThresholdDays);
    }

    /**
     * @return string|null
     */
    public function getTrialWelcomeEmailTemplateCode()
    {
        return $this->getData(self::TRIAL_WELCOME_EMAIL_TEMPLATE_CODE);
    }

    /**
     * @param string|null $trialWelcomeEmailTemplateCode
     * @return $this
     */
    public function setTrialWelcomeEmailTemplateCode($trialWelcomeEmailTemplateCode)
    {
        return $this->setData(self::TRIAL_WELCOME_EMAIL_TEMPLATE_CODE, $trialWelcomeEmailTemplateCode);
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
}
