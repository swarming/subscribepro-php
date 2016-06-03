<?php

namespace SubscribePro\Service\WebhookEvent\Endpoint;

interface EndpointInterface
{
    /**
     * Data fields
     */
    const ID = 'id';
    const STATUS = 'status';
    const URL = 'url';
    const ALL_SUBSCRIBED_EVENT_TYPES = 'all_subscribed_event_types';
    const SUBSCRIBED_EVENT_TYPES = 'subscribed_event_types';
    const CREATED = 'created';
    const UPDATED = 'updated';

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
     * @return string
     */
    public function getUrl();

    /**
     * @return bool
     */
    public function getAllSubscribedEventTypes();

    /**
     * @return string
     */
    public function getSubscribedEventTypes();

    /**
     * @param string|null $format
     * @return string
     */
    public function getCreated($format = null);

    /**
     * @param string|null $format
     * @return string
     */
    public function getUpdated($format = null);
}
