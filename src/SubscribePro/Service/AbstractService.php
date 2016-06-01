<?php

namespace SubscribePro\Service;

abstract class AbstractService
{
    /**
     * @var \SubscribePro\Http
     */
    protected $httpClient;

    /**
     * @var \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected $dataFactory;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param \SubscribePro\Sdk $sdk
     * @param array $config
     */
    public function __construct(
        \SubscribePro\Sdk $sdk,
        array $config = []
    ) {
        $this->httpClient = $sdk->getHttp();
        $this->config = $config;
        $this->dataFactory = $this->createDataFactory($sdk);
    }

    /**
     * @param string $key
     * @param mixed|null $defaultValue
     * @return mixed|null
     */
    protected function getConfigValue($key, $defaultValue = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $defaultValue;
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    abstract protected function createDataFactory(\SubscribePro\Sdk $sdk);

    /**
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected function getDataFactory()
    {
        return $this->dataFactory;
    }

    /**
     * @param array $response
     * @param string $entityName
     * @param \SubscribePro\Service\DataObjectInterface|null $item
     * @return \SubscribePro\Service\DataObjectInterface
     */
    protected function retrieveItem($response, $entityName, DataObjectInterface $item = null)
    {
        $itemData = !empty($response[$entityName]) ? $response[$entityName] : [];
        $item = $item ?: $this->dataFactory->createItem();
        $item->importData($itemData);
        return $item;
    }

    /**
     * @param array $response
     * @param string $entitiesName
     * @return \SubscribePro\Service\DataObjectInterface[]
     */
    protected function retrieveItems($response, $entitiesName)
    {
        $responseData = !empty($response[$entitiesName]) ? $response[$entitiesName] : [];
        $items = $this->createItems($responseData);
        return $items;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObjectInterface[]
     */
    protected function createItems(array $data = [])
    {
        return array_map(function ($itemData) {
            return $this->dataFactory->createItem($itemData);
        }, $data);
    }
}
