<?php

namespace SubscribePro\Service\Subscription;

use SubscribePro\Service\AbstractDataObjectService;

/**
 * @method \SubscribePro\Service\Subscription\SubscriptionInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Subscription\SubscriptionInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Subscription\SubscriptionInterface saveItem(SubscriptionInterface $item)
 */
class SubscriptionService extends AbstractDataObjectService
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
     * @var string
     */
    protected $entityName = 'subscription';

    /**
     * @var string
     */
    protected $entitiesName = 'subscriptions';

    /**
     * @var string
     */
    protected $createUrl = '/v2/subscription.json';

    /**
     * @var string
     */
    protected $entityUrl = '/v2/subscriptions/%d.json';

    /**
     * @var string
     */
    protected $entitiesUrl = '/v2/subscriptions.json';

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
     * @param int|null $customerId
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface[]
     * @throws \RuntimeException
     */
    public function loadItems($customerId = null)
    {
        $filters = $customerId ? [SubscriptionInterface::CUSTOMER_ID => $customerId] : [];

        return parent::loadItems($filters);
    }
}
