<?php

namespace SubscribePro\Service;

class DataObject implements DataInterface
{
    /**
     * @var string
     */
    protected $idField = 'id';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $creatingFields = [];

    /**
     * @var array
     */
    protected $updatingFields = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->importData($data);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function importData(array $data = [])
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->getData($this->idField);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    protected function setData($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
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
     * @return bool
     */
    public function isNew()
    {
        return !(bool)$this->getId();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    protected function getFormFields()
    {
        return $this->isNew() ? $this->creatingFields : $this->updatingFields;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getFormData()
    {
        if (!$this->isValid()) {
            throw new \InvalidArgumentException('Not all required fields are set.');
        }

        return array_intersect_key($this->data, $this->getFormFields());
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->checkRequiredFields($this->getFormFields());
    }

    /**
     * @param  array $fields
     * @return bool
     */
    protected function checkRequiredFields(array $fields)
    {
        foreach ($fields as $field => $isRequired) {
            if ($isRequired && null === $this->getData($field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $date
     * @param string|null $outputFormat
     * @param string $inputFormat
     * @return string
     */
    protected function processDate($date, $outputFormat = null, $inputFormat = \DateTime::ISO8601)
    {
        if (!$outputFormat) {
            return $date;
        }

        $dateTime = \DateTime::createFromFormat($inputFormat, $date);
        return $dateTime ? $dateTime->format($outputFormat) : $date;
    }
}
