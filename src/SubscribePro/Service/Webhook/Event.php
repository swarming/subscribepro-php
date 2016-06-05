<?php

namespace SubscribePro\Service\Webhook;

use SubscribePro\Service\Webhook\Event\DestinationInterface;

class Event implements EventInterface
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @return \SubscribePro\Service\Customer\CustomerInterface
     */
    public function getCustomer()
    {
        return $this->getData(self::CUSTOMER);
    }

    /**
     * @return \SubscribePro\Service\Subscription\SubscriptionInterface
     */
    public function getSubscription()
    {
        return $this->getData(self::SUBSCRIPTION);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @return \SubscribePro\Service\Webhook\Event\DestinationInterface[]
     */
    public function getDestinations()
    {
        return $this->getData(self::DESTINATIONS);
    }

    /**
     * @param string|null $format
     * @return string
     */
    public function getCreated($format = null)
    {
        return $this->getDatetimeData(self::CREATED, $format);
    }

    /**
     * @param string|null $format
     * @return string
     */
    public function getUpdated($format = null)
    {
        return $this->getDatetimeData(self::UPDATED, $format);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->data;
        $data[self::CUSTOMER] = $this->getCustomer()->toArray();
        $data[self::SUBSCRIPTION] = $this->getSubscription()->toArray();
        $data[self::DESTINATIONS] = array_map(function (DestinationInterface $destination) {
            return $destination->toArray();
        }, $this->getDestinations());
        return $data;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    protected function getData($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * @param string $field
     * @param string|null $format
     * @return string
     */
    protected function getDatetimeData($field, $format = null)
    {
        $date = $this->getData($field);
        return $format && $date ? $this->formatDate($date, $format, \DateTime::ISO8601) : $date;
    }

    /**
     * @param string $date
     * @param string $outputFormat
     * @param string $inputFormat
     * @return string
     */
    protected function formatDate($date, $outputFormat, $inputFormat)
    {
        $dateTime = \DateTime::createFromFormat($inputFormat, $date);
        return $dateTime ? $dateTime->format($outputFormat) : $date;
    }
}
