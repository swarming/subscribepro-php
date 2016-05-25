<?php

namespace SubscribePro\Service;

class DataFactory
{
    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @param string $itemClass
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\DataObject'
    ) {
        if (!is_a($itemClass, '\SubscribePro\Service\DataObjectInterface', true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement DataObjectInterface.");
        }
        $this->itemClass = $itemClass;
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
     * @return DataObjectInterface[]
     */
    public function createCollection(array $data = [])
    {
        return array_map(function ($itemData) {
            return $itemData instanceOf DataObject ? $itemData : $this->createItem($itemData);
        }, $data);
    }
}
