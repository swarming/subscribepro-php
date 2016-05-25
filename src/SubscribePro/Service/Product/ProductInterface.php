<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\DataObjectInterface;

interface ProductInterface extends DataObjectInterface
{
    /**
     * @return string|null
     */
    public function getSku();

    /**
     * @param string|null $sku
     * @return $this
     */
    public function setSku($sku);

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return bool|null
     */
    public function getShowOnUi();

    /**
     * @param bool|null $showOnUi
     * @return $this
     */
    public function setShowOnUi($showOnUi);

    /**
     * @return float|null
     */
    public function getMinQty();

    /**
     * @param float|null $minQty
     * @return $this
     */
    public function setMinQty($minQty);

    /**
     * @return float|null
     */
    public function getMaxQty();

    /**
     * @param float|null $maxQty
     * @return $this
     */
    public function setMaxQty($maxQty);

    /**
     * @return float|null
     */
    public function getPrice();

    /**
     * @param float|null $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * @return float|null
     */
    public function getDiscount();

    /**
     * @param float|null $discount
     * @return $this
     */
    public function setDiscount($discount);

    /**
     * @return bool|null
     */
    public function getIsDiscountPercentage();

    /**
     * @param bool|null $isDiscountPercentage
     * @return $this
     */
    public function setIsDiscountPercentage($isDiscountPercentage);

    /**
     * @return string|null
     */
    public function getSubscriptionOptionMode();

    /**
     * @param string|null $subscriptionOptionMode
     * @return $this
     */
    public function setSubscriptionOptionMode($subscriptionOptionMode);

    /**
     * @return string|null
     */
    public function getDefaultSubscriptionOption();

    /**
     * @param string|null $defaultSubscriptionOption
     * @return $this
     */
    public function setDefaultSubscriptionOption($defaultSubscriptionOption);

    /**
     * @return string|null
     */
    public function getDefaultInterval();

    /**
     * @param string|null $defaultInterval
     * @return $this
     */
    public function setDefaultInterval($defaultInterval);

    /**
     * @return array|null
     */
    public function getIntervals();

    /**
     * @param array|null $intervals
     * @return $this
     */
    public function setIntervals($intervals);

    /**
     * @return string|null
     */
    public function getProductOptionsMode();

    /**
     * @param string|null $productOptionsMode
     * @return $this
     */
    public function setProductOptionsMode($productOptionsMode);

    /**
     * @return bool|null
     */
    public function getIsTrialProduct();

    /**
     * @param bool|null $isTrialProduct
     * @return $this
     */
    public function setIsTrialProduct($isTrialProduct);

    /**
     * @return string|null
     */
    public function getTrialInterval();

    /**
     * @param string|null $trialInterval
     * @return $this
     */
    public function setTrialInterval($trialInterval);

    /**
     * @return float|null
     */
    public function getTrialPrice();

    /**
     * @param float|null $trialPrice
     * @return $this
     */
    public function setTrialPrice($trialPrice);

    /**
     * @return string|null
     */
    public function getTrialFullProductSku();

    /**
     * @param string|null $trialFullProductSku
     * @return $this
     */
    public function setTrialFullProductSku($trialFullProductSku);

    /**
     * @return string|null
     */
    public function getTrialEmailTemplateCode();

    /**
     * @param string|null $trialEmailTemplateCode
     * @return $this
     */
    public function setTrialEmailTemplateCode($trialEmailTemplateCode);

    /**
     * @return float|null
     */
    public function getTrialEmailThresholdDays();

    /**
     * @param float|null $trialEmailThresholdDays
     * @return $this
     */
    public function setTrialEmailThresholdDays($trialEmailThresholdDays);

    /**
     * @return string|null
     */
    public function getTrialWelcomeEmailTemplateCode();

    /**
     * @param string|null $trialWelcomeEmailTemplateCode
     * @return $this
     */
    public function setTrialWelcomeEmailTemplateCode($trialWelcomeEmailTemplateCode);

    /**
     * @return bool|null
     */
    public function getIsSubscriptionEnabled();

    /**
     * @param bool|null $isSubscriptionEnabled
     * @return $this
     */
    public function setIsSubscriptionEnabled($isSubscriptionEnabled);

    /**
     * @return string|null
     */
    public function getCreated();

    /**
     * @return string|null
     */
    public function getUpdated();
}
