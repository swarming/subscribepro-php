<?php

namespace SubscribePro\Service\WebhookEvent;

use SubscribePro\Service\DataFactoryInterface;

class WebhookEventFactory implements DataFactoryInterface
{
    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @var \SubscribePro\Service\DataFactoryInterface
     */
    protected $destinationFactory;

    /**
     * @var \SubscribePro\Service\DataFactoryInterface
     */
    protected $customerFactory;

    /**
     * @var \SubscribePro\Service\DataFactoryInterface
     */
    protected $subscriptionFactory;

    /**
     * @param \SubscribePro\Service\DataFactoryInterface $customerFactory
     * @param \SubscribePro\Service\DataFactoryInterface $subscriptionFactory
     * @param \SubscribePro\Service\DataFactoryInterface $destinationFactory
     * @param string $instanceName
     */
    public function __construct(
        \SubscribePro\Service\DataFactoryInterface $customerFactory,
        \SubscribePro\Service\DataFactoryInterface $subscriptionFactory,
        \SubscribePro\Service\DataFactoryInterface $destinationFactory,
        $instanceName = '\SubscribePro\Service\WebhookEvent\WebhookEvent'
    ) {
        $webhookInterface = '\SubscribePro\Service\WebhookEvent\WebhookEventInterface';
        if (!is_subclass_of($instanceName, $webhookInterface)) {
            throw new \InvalidArgumentException("{$instanceName} must implement {$webhookInterface}.");
        }
        
        $this->instanceName = $instanceName;
        $this->destinationFactory = $destinationFactory;
        $this->customerFactory = $customerFactory;
        $this->subscriptionFactory = $subscriptionFactory;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\WebhookEvent\WebhookEventInterface
     */
    public function create(array $data = [])
    {
        $jsonData = $this->getJsonData($data, WebhookEventInterface::DATA);
        $customerData = $this->getFieldData($jsonData, WebhookEventInterface::CUSTOMER);
        $subscriptionData = $this->getFieldData($jsonData, WebhookEventInterface::SUBSCRIPTION);
        $destinationsData = $this->getFieldData($data, WebhookEventInterface::DESTINATIONS);
            
        $data[WebhookEventInterface::DESTINATIONS] = $this->createDestinationItems($destinationsData);
        $data[WebhookEventInterface::CUSTOMER] = $this->customerFactory->create($customerData);
        $data[WebhookEventInterface::SUBSCRIPTION] = $this->subscriptionFactory->create($subscriptionData);
        
        if (isset($data[WebhookEventInterface::DATA])) {
            unset($data[WebhookEventInterface::DATA]);
        }
        
        return new $this->instanceName($data);
    }

    /**
     * @param array $data
     * @param string $field
     * @return array
     */
    protected function getFieldData($data, $field)
    {
        return isset($data[$field]) && is_array($data[$field]) ? $data[$field] : [];
    }

    /**
     * @param array $data
     * @param string $field
     * @return array
     */
    protected function getJsonData($data, $field)
    {
        return isset($data[$field]) && is_string($data[$field]) ? json_decode($data[$field], true) : [];
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\WebhookEvent\Destination\DestinationInterface[]
     */
    protected function createDestinationItems(array $data = [])
    {
        return array_map(function ($itemData) {
            return $this->destinationFactory->create($itemData);
        }, $data);
    }
}
