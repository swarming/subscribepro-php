<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Subscription\SubscriptionInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Subscription\SubscriptionInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Subscription\SubscriptionInterface saveItem(SubscriptionInterface $item)
 */
class SubscriptionService extends AbstractService
{
    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'subscription';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'subscriptions';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return '/v2/subscription.json';
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v2/subscriptions/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v2/subscriptions.json';
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new SubscriptionFactory(
            $sdk->getAddressService()->getDataFactory(),
            $sdk->getPaymentProfileService()->getDataFactory(),
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Subscription\Subscription')
        );
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface[]
     * @throws \RuntimeException
     */
    public function loadItems($customerId = null)
    {
        $filters = $customerId ? [SubscriptionInterface::CUSTOMER_ID => $customerId] : [];

        return parent::loadItems($filters);
    }

    /**
     * @param int $subscriptionId
     * @throws \RuntimeException
     */
    public function cancel($subscriptionId)
    {
        $this->httpClient->post("v2/subscriptions/{$subscriptionId}/cancel.json");
    }

    /**
     * @param int $subscriptionId
     * @throws \RuntimeException
     */
    public function pause($subscriptionId)
    {
        $this->httpClient->post("v2/subscriptions/{$subscriptionId}/pause.json");
    }

    /**
     * @param int $subscriptionId
     * @throws \RuntimeException
     */
    public function restart($subscriptionId)
    {
        $this->httpClient->post("v2/subscriptions/{$subscriptionId}/restart.json");
    }

    /**
     * @param int $subscriptionId
     * @throws \RuntimeException
     */
    public function skip($subscriptionId)
    {
        $this->httpClient->post("v2/subscriptions/{$subscriptionId}/skip.json");
    }
}
