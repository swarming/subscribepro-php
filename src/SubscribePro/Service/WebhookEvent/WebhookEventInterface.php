<?php

namespace SubscribePro\Service\WebhookEvent;

interface WebhookEventInterface
{
    /**
     * Data fields
     */
    const ID = 'id';
    const TYPE = 'type';
    const DATA = 'data';
    const CUSTOMER = 'customer';
    const SUBSCRIPTION = 'subscription';
    const DESTINATIONS = 'destinations';
    const CREATED = 'created';
    const UPDATED = 'updated';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return \SubscribePro\Service\Customer\CustomerInterface
     */
    public function getCustomer();

    /**
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function getSubscription();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return \SubscribePro\Service\WebhookEvent\Destination\DestinationInterface[]
     */
    public function getDestinations();

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
