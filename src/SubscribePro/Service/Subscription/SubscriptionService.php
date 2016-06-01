<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\AbstractService;

class SubscriptionService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'subscription';

    const ENTITY_NAME = 'subscription';
    const ENTITIES_NAME = 'subscriptions';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        return new SubscriptionFactory(
            $sdk->getAddressService()->getDataFactory(),
            $sdk->getPaymentProfileService()->getDataFactory(),
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Subscription\Subscription')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function createSubscription(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\Subscription\SubscriptionInterface $item
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     * @throws \RuntimeException
     */
    public function saveSubscription(SubscriptionInterface $item)
    {
        $url = $item->isNew() ? '/v2/subscription.json' : "/v2/subscriptions/{$item->getId()}.json";
        $response = $this->httpClient->post($url, [self::ENTITY_NAME => $item->getFormData()]);
        return $this->retrieveItem($response, self::ENTITY_NAME, $item);
    }

    /**
     * @param int $subscriptionId
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     * @throws \RuntimeException
     */
    public function loadSubscription($subscriptionId)
    {
        $response = $this->httpClient->get("/v2/subscriptions/{$subscriptionId}.json");
        return $this->retrieveItem($response, self::ENTITY_NAME);
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface[]
     * @throws \RuntimeException
     */
    public function loadSubscriptions($customerId = null)
    {
        $filters = $customerId ? [SubscriptionInterface::CUSTOMER_ID => $customerId] : [];
        $response = $this->httpClient->get('/v2/subscriptions.json', $filters);
        return $this->retrieveItems($response, self::ENTITIES_NAME);
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
