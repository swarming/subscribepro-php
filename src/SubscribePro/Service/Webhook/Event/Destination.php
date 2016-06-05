<?php

namespace SubscribePro\Service\Webhook\Event;

class Destination implements DestinationInterface
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
     * @param string|null $format
     * @return string
     */
    public function getLastAttempt($format = null)
    {
        return $this->getDatetimeData(self::LAST_ATTEMPT, $format);
    }

    /**
     * @return string|null
     */
    public function getLastErrorMessage()
    {
        return $this->getData(self::LAST_ERROR_MESSAGE);
    }

    /**
     * @return \SubscribePro\Service\Webhook\Event\Destination\EndpointInterface
     */
    public function getEndpoint()
    {
        return $this->getData(self::ENDPOINT);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->data;
        $data[self::ENDPOINT] = $this->getEndpoint()->toArray();
        return $data;
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
