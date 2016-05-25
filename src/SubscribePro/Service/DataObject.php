<?php

namespace SubscribePro\Service;

class DataObject implements DataObjectInterface
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
    protected $originData = [];

    /**
     * @var array
     */
    protected $changes = [];

    /**
     * @var array
     */
    protected $nonUpdatableFields = ['id'];

    /**
     * @var array
     */
    protected $requiredFields = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->initData($data);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function initData(array $data = [])
    {
        $this->data = $data;
        if (isset($data[$this->idField]) && !empty($data[$this->idField])) {
            $this->originData = $data;
            $this->changes = [];
        } else {
            $this->changes = $data;
            $this->originData = [];
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getData($this->idField);
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData($this->idField, $id);
        $this->originData = [];
        $this->changes = $this->data;
        
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    protected function setData($key, $value)
    {
        if (empty($this->originData[$key]) || $this->originData[$key] != $value) {
            $this->changes[$key] = $value;
        } else if (isset($this->changes[$key])) {
            unset($this->changes[$key]);
        }

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
     * @return bool
     */
    public function isChanged()
    {
        return !empty($this->changes);
    }

    /**
     * @return array
     */
    public function getChangedData()
    {
        return $this->changes;
    }

    /**
     * @param bool $changedOnly
     * @return array
     */
    public function getFormData($changedOnly = true)
    {
        $data = $changedOnly ? $this->changes : $this->data;
        return array_diff_key($data, array_flip($this->nonUpdatableFields));
    }

    /**
     * @return array
     */
    public function getRequiredFields()
    {
        return $this->requiredFields;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->requiredFields as $requiredField) {
            if (empty($this->getData($requiredField))) {
                return false;
            }
        }
        return true;
    }
}
