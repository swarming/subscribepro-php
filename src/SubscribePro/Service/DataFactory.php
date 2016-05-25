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
     * @param string $itemType
     */
    public function __construct(
        $itemClass = '\SubscribePro\Service\DataObject',
        $itemType = '\SubscribePro\Service\DataObjectInterface'
    ) {
        if (!is_a($itemClass, $itemType, true)) {
            throw new \InvalidArgumentException("{$itemClass} must implement {$itemType}.");
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
}
