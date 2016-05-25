<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\AbstractService;

class SubscriptionService extends AbstractService
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'itemClass' => '\SubscribePro\Service\Subscription\Subscription',
    ];

    /**
     * @var array
     */
    protected $staticConfig = [
        'itemType' => '\SubscribePro\Service\Subscription\SubscriptionInterface',
    ];

    /**
     * @param string $id
     * @return \SubscribePro\Service\Subscription\Subscription
     * @throws \RuntimeException
     */
    public function loadItem($id)
    {
        $response = $this->httpClient->get("/v2/subscriptions/{$id}.json");

        $itemData = !empty($response['subscription']) ? $response['subscription'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Subscription\SubscriptionInterface $item
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getFormUri($item), ['subscription' => $item->getFormData()]);

        $itemData = !empty($response['subscription']) ? $response['subscription'] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Subscription\SubscriptionInterface $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/subscription.json' : "v2/subscriptions/{$item->getId()}.json";
    }

    /**
     * @param string|null $customerId
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface[]
     * @throws \RuntimeException
     */
    public function loadList($customerId = null)
    {
        $params = $customerId ? ['customer_id' => $customerId] : [];
        $response = $this->httpClient->get('/v2/subscriptions.json', $params);

        $subscriptionsData = !empty($response['subscriptions']) ? $response['subscriptions'] : [];
        return $this->buildList($subscriptionsData);
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
