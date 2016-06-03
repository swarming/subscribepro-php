<?php

namespace SubscribePro\Service\WebhookEvent\Destination;

interface DestinationInterface
{
    /**
     * Data fields
     */
    const ID = 'id';
    const STATUS = 'status';
    const LAST_ATTEMPT = 'last_attempt';
    const ENDPOINT = 'endpoint';
    const LAST_ERROR_MESSAGE = 'last_error_message';

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string|null $format
     * @return string
     */
    public function getLastAttempt($format = null);

    /**
     * @return string|null
     */
    public function getLastErrorMessage();

    /**
     * @return \SubscribePro\Service\WebhookEvent\Endpoint\EndpointInterface
     */
    public function getEndpoint();
}
