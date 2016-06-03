<?php

namespace SubscribePro\Service\WebhookEvent\Destination;

use SubscribePro\Service\DataFactoryInterface;

class DestinationFactory implements DataFactoryInterface
{
    /**
     * @var string
     */
    protected $instanceName;

    /**
     * @var string
     */
    protected $endpointInstanceName;

    /**
     * @param string $instanceName
     * @param string $endpointInstanceName
     */
    public function __construct(
        $instanceName = '\SubscribePro\Service\WebhookEvent\Destination\Destination',
        $endpointInstanceName = '\SubscribePro\Service\WebhookEvent\Endpoint\Endpoint'
    ) {
        $destinationInterface = '\SubscribePro\Service\WebhookEvent\Destination\DestinationInterface';
        $endpointInterface = '\SubscribePro\Service\WebhookEvent\Endpoint\EndpointInterface';

        if (!is_subclass_of($instanceName, $destinationInterface)) {
            throw new \InvalidArgumentException("{$instanceName} must implement {$destinationInterface}.");
        }
        if (!is_subclass_of($endpointInstanceName, $endpointInterface)) {
            throw new \InvalidArgumentException("{$endpointInstanceName} must implement {$endpointInterface}.");
        }
        $this->instanceName = $instanceName;
        $this->endpointInstanceName = $endpointInstanceName;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\WebhookEvent\Destination\DestinationInterface
     */
    public function create(array $data = [])
    {
        $endpointData = $this->getFieldData($data, DestinationInterface::ENDPOINT);
        $data[DestinationInterface::ENDPOINT] = new $this->endpointInstanceName($endpointData);
        
        return new $this->instanceName($data);
    }

    /**
     * @param array $data
     * @param string $field
     * @return array
     */
    protected function getFieldData($data, $field)
    {
        return !empty($data[$field]) ? $data[$field] : [];
    }
}
