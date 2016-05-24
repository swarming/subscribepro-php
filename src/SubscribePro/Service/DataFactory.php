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
    protected $collectionClass;

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
        if (!is_a($itemClass, $itemType, true)) {
            throw new \InvalidArgumentException("{$itemClass} must be an instance of {$itemType}.");
        }
        if (!is_a($collectionClass, $collectionType, true)) {
            throw new \InvalidArgumentException("{$collectionClass} must be an instance of {$collectionType}.");
        }
        $this->itemClass = $itemClass;
        $this->collectionClass = $collectionClass;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObject
     */
    public function createItem(array $data = [])
    {
        return new $this->itemClass($data);
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataCollection
     */
    public function createCollection(array $data = [])
    {
        return new $this->collectionClass($this, $data);
    }
}
