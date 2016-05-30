<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\AbstractService;

class SubscriptionService extends AbstractService
{
    /**
     * @param array $data
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function createSubscription(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\Subscription\SubscriptionInterface $item
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     * @throws \RuntimeException
     */
    public function saveSubscription(SubscriptionInterface $item)
    {
        return $this->saveItem($item, '/v2/subscription.json', "/v2/subscriptions/{$item->getId()}.json", 'subscription');
    }

    /**
     * @param $id
     * @throws \RuntimeException
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function loadSubscription($id)
    {
        return $this->loadItem("/v2/subscriptions/{$id}.json", 'subscription');
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface[]
     * @throws \RuntimeException
     */
    public function loadSubscriptions($customerId = null)
    {
        $filters = $customerId ? [SubscriptionInterface::CUSTOMER_ID => $customerId] : [];

        return $this->loadItems($filters, '/v2/subscriptions.json', 'subscriptions');
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
}
