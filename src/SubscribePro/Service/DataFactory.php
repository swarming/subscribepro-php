<?php

namespace SubscribePro\Service;

class DataFactory
{
    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @var string
     */
    protected $itemType;

    /**
     * @var string
     */
    protected $collectionClass;

    /**
     * @var string
     */
    protected $collectionType;

    /**
     * @param string $itemClass
     * @param string $itemType
     * @param string $collectionClass
     * @param string $collectionType
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\DataObject',
        $itemType = '\SubscribePro\Service\DataObject',
        $collectionClass = '\SubscribePro\Service\DataCollection',
        $collectionType = '\SubscribePro\Service\DataCollection'
    ) {
        $this->itemClass = $itemClass;
        $this->itemType = $itemType;
        $this->collectionClass = $collectionClass;
        $this->collectionType = $collectionType;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObject
     */
    public function createItem(array $data = [])
    {
        $item = new $this->itemClass($data);
        if (!$item instanceof $this->itemType) {
            throw new \InvalidArgumentException(get_class($item) . " must be an instance of {$this->itemType}.");
        }
        return $item;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataCollection
     */
    public function createCollection(array $data = [])
    {
        $collection = new $this->collectionClass($this, $data);
        if (!$collection instanceof $this->collectionType) {
            throw new \InvalidArgumentException(get_class($collection) . " must be an instance of {$this->collectionType}.");
        }
        return $collection;
    }
}
