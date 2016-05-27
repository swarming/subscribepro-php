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
     * @return string
     */
    abstract protected function getEntityName();

    /**
     * @return string
     */
    abstract protected function getEntitiesName();

    /**
     * @return string
     */
    abstract protected function getCreateUrl();

    /**
     * @param string $id
     * @return string
     */
    abstract protected function getEntityUrl($id);

    /**
     * @return string
     */
    abstract protected function getEntitiesUrl();

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
    public function createItem(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param int $spId
     * @return \SubscribePro\Service\DataObjectInterface
     * @throws \RuntimeException
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get($this->getEntityUrl($spId));

        $itemData = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\DataObjectInterface $item
     * @return \SubscribePro\Service\DataObjectInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getFormUri($item), [$this->getEntityName() => $item->getFormData()]);

        $itemData = !empty($response[$this->getEntityName()]) ? $response[$this->getEntityName()] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\DataObjectInterface $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? $this->getCreateUrl() : $this->getEntityUrl($item->getId());
    }

    /**
     * @param array|string|int|null $filters
     * @throws \RuntimeException
     * @return \SubscribePro\Service\DataObjectInterface[]
     */
    public function loadItems($filters = null)
    {
        $params = is_array($filters) ? $filters : [];
        $response = $this->httpClient->get($this->getEntitiesUrl(), $params);

        $responseData = !empty($response[$this->getEntitiesName()]) ? $response[$this->getEntitiesName()] : [];
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
