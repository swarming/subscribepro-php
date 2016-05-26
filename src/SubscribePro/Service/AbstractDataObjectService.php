<?php

namespace SubscribePro\Service;

abstract class AbstractDataObjectService extends AbstractService
{
    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var string
     */
    protected $entitiesName;

    /**
     * @var string
     */
    protected $createUrl;

    /**
     * @var string
     */
    protected $entityUrl;

    /**
     * @var string
     */
    protected $entitiesUrl;

    /**
     * AbstractDataObjectService constructor.
     * @param \SubscribePro\Http $httpClient
     * @param array $config
     */
    public function __construct(\SubscribePro\Http $httpClient, array $config)
    {
        parent::__construct($httpClient, $config);
        if (!$this->entityName || !$this->entitiesName || !$this->createUrl || !$this->entityUrl || !$this->entitiesUrl) {
            throw new \InvalidArgumentException('Not all config params are specified in service.');
        }
    }

    /**
     * @param int $spId
     * @return \SubscribePro\Service\DataObjectInterface
     * @throws \RuntimeException
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get($this->getEntityUrl($spId));

        $itemData = !empty($response[$this->entityName]) ? $response[$this->entityName] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param array|string|int|null $filters
     * @throws \RuntimeException
     * @return DataObjectInterface[]
     */
    public function loadItems($filters = null)
    {
        $params = is_array($filters) ? $filters : [];
        $response = $this->httpClient->get($this->getEntitiesUrl(), $params);

        $responseData = !empty($response[$this->entitiesName]) ? $response[$this->entitiesName] : [];
        return $this->buildList($responseData);
    }

    /**
     * @param \SubscribePro\Service\DataObjectInterface $item
     * @return \SubscribePro\Service\DataObjectInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getFormUri($item), [$this->entityName => $item->getFormData()]);

        $itemData = !empty($response[$this->entityName]) ? $response[$this->entityName] : [];
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
     * @return string
     */
    protected function getCreateUrl()
    {
        return $this->createUrl;
    }

    /**
     * @param $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return sprintf($this->entityUrl, $id);
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return $this->entitiesUrl;
    }
}
