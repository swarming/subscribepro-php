<?php

namespace SubscribePro\Service\WebhookEvent\Endpoint;

class Endpoint implements EndpointInterface
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
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    /**
     * @return bool
     */
    public function getAllSubscribedEventTypes()
    {
        return $this->getData(self::ALL_SUBSCRIBED_EVENT_TYPES);
    }

    /**
     * @return string
     */
    public function getSubscribedEventTypes()
    {
        return $this->getData(self::SUBSCRIBED_EVENT_TYPES);
    }

    /**
     * @param string|null $format
     * @return string
     */
    public function getCreated($format = null)
    {
        return $this->getDataDatetime(self::CREATED, $format);
    }

    /**
     * @param string|null $format
     * @return string
     */
    public function getUpdated($format = null)
    {
        return $this->getDataDatetime(self::UPDATED, $format);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param string $field
     * @param string|null $format
     * @return string
     */
    protected function getDataDatetime($field, $format = null)
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

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    protected function getData($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }
}
