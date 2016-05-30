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
        $this->createDataFactory($sdk);
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
     * @param array $data
     * @return \SubscribePro\Service\DataObjectInterface
     */
    protected function createItem(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param string $entityUrl
     * @param string $entityName
     * @return \SubscribePro\Service\DataObjectInterface
     * @throws \RuntimeException
     */
    protected function loadItem($entityUrl, $entityName)
    {
        $response = $this->httpClient->get($entityUrl);

        $itemData = !empty($response[$entityName]) ? $response[$entityName] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\DataObjectInterface $item
     * @param string|null $createUrl
     * @param string|null $updateUrl
     * @param string $entityName
     * @param string|null $createMethod
     * @param string|null $updateMethod
     * @return \SubscribePro\Service\DataObjectInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    protected function saveItem($item, $createUrl, $updateUrl, $entityName, $createMethod = 'POST', $updateMethod = 'POST')
    {
        if ($item->isNew() && !$createUrl) {
            throw new \BadMethodCallException("Saving new instances is not allowed in {$entityName} service");
        }
        if (!$item->isNew() && !$updateUrl) {
            throw new \BadMethodCallException("Update is not allowed in {$entityName} service");
        }
        
        $url = $item->isNew() ? $createUrl : $updateUrl;
        $method = $item->isNew() ? $createMethod : $updateMethod;
        $response = $this->httpClient->request($method, $url, [$entityName => $item->getFormData()]);
        
        $itemData = !empty($response[$entityName]) ? $response[$entityName] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param array|string|int|null $filters
     * @param string $entitiesUrl
     * @param string $entitiesName
     * @throws \RuntimeException
     * @return \SubscribePro\Service\DataObjectInterface[]
     */
    protected function loadItems($filters = null, $entitiesUrl, $entitiesName)
    {
        $params = is_array($filters) ? $filters : [];
        $response = $this->httpClient->get($entitiesUrl, $params);

        $responseData = !empty($response[$entitiesName]) ? $response[$entitiesName] : [];
        return $this->createItems($responseData);
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObjectInterface[]
     */
    protected function createItems(array $data = [])
    {
        return array_map(function ($itemData) {
            return $this->createItem($itemData);
        }, $data);
    }
}
