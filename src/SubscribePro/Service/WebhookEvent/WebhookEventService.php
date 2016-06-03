<?php

namespace SubscribePro\Service\WebhookEvent;

use SubscribePro\Sdk;
use SubscribePro\Service\AbstractService;
use SubscribePro\Exception\HttpException;
use SubscribePro\Service\WebhookEvent\Destination\DestinationFactory;

class WebhookEventService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'webhook_event';
    
    const API_NAME_WEBHOOK_EVENT = 'webhook_event';
    
    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataFactoryInterface
     */
    protected function createDataFactory(Sdk $sdk)
    {
        $destinationFactory = new DestinationFactory(
            $this->getConfigValue('destination_instance_name', '\SubscribePro\Service\WebhookEvent\Destination\Destination'),
            $this->getConfigValue('endpoint_instance_name', '\SubscribePro\Service\WebhookEvent\Endpoint\Endpoint')
        );
        return new WebhookEventFactory(
            $sdk->getCustomerService()->getDataFactory(),
            $sdk->getSubscriptionService()->getDataFactory(),
            $destinationFactory,
            $this->getConfigValue(Sdk::CONFIG_INSTANCE_NAME, '\SubscribePro\Service\WebhookEvent\WebhookEvent')
        );
    }

    /**
     * @return bool
     */
    public function webhookTest()
    {
        try {
            $this->httpClient->post('/v2/webhook-test.json');
        } catch (HttpException $exception) {
            return false;
        }
        
        return true;
    }

    /**
     * @param int $eventId
     * @return \SubscribePro\Service\WebhookEvent\WebhookEventInterface
     */
    public function loadWebhookEvent($eventId)
    {
        $response = $this->httpClient->get("/v2/webhook-events/{$eventId}.json");
        $itemData = !empty($response[self::API_NAME_WEBHOOK_EVENT]) ? $response[self::API_NAME_WEBHOOK_EVENT] : [];
        
        return $this->dataFactory->create($itemData);
    }
}
