<?php

namespace SubscribePro\Service;

abstract class AbstractService
{
    /**
     * @var \SubscribePro\Http
     */
    protected $httpClient;

    /**
     * @var \SubscribePro\Service\DataFactory
     */
    protected $dataFactory;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $staticConfig = [];

    /**
     * @param \SubscribePro\Http $httpClient
     * @param array $config
     */
    public function __construct(
        \SubscribePro\Http $httpClient,
        array $config = []
    ) {
        $this->httpClient = $httpClient;
        $this->config = array_merge($this->defaultConfig, $config, $this->staticConfig);
        $this->dataFactory = new DataFactory(
            $this->getConfigValue('itemClass', '\SubscribePro\Service\DataObject'),
            $this->getConfigValue('itemType', '\SubscribePro\Service\DataObjectInterface')
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
     * @return \SubscribePro\Service\DataObjectInterface
     */
    public function createItem(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObjectInterface[]
     */
    protected function buildList(array $data = [])
    {
        return array_map(function ($itemData) {
            return $itemData instanceOf DataObject ? $itemData : $this->createItem($itemData);
        }, $data);
    }
}
