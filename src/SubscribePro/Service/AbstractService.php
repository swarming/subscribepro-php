<?php

namespace SubscribePro\Service;

abstract class AbstractService
{
    /**
     * @var \SubscribePro\Http
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \SubscribePro\Service\DataFactory
     */
    protected $dataFactory;

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var string
     */
    protected $itemType = '\SubscribePro\Service\DataObject';

    /**
     * @param \SubscribePro\Http $httpClient
     * @param array $config
     */
    public function __construct(
        \SubscribePro\Http $httpClient,
        array $config = []
    ) {
        $this->httpClient = $httpClient;
        $this->config = array_merge($this->defaultConfig, $config);
        $this->dataFactory = new DataFactory(
            $this->getConfigValue('itemClass', '\SubscribePro\Service\DataObject')
        );
    }

    /**
     * @param string $key
     * @param mixed|null $defaultValue
     * @return mixed|null
     */
    public function getConfigValue($key, $defaultValue = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $defaultValue;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setConfigValue($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Product\Product
     */
    public function createItem(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param array $data
     * @return DataObjectInterface[]
     */
    public function createCollection(array $data = [])
    {
        return $this->dataFactory->createCollection($data);
    }
}
