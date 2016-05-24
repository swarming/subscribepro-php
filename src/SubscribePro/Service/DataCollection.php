<?php

namespace SubscribePro\Service;

class DataCollection
{
    /**
     * @var \SubscribePro\Service\DataFactory
     */
    protected $dataFactory;

    /**
     * @var \SubscribePro\Service\DataObject[]
     */
    protected $items = [];

    /**
     * @param \SubscribePro\Service\DataFactory $dataFactory
     * @param array $items
     */
    public function __construct(
        \SubscribePro\Service\DataFactory $dataFactory,
        array $items = []
    ) {
        $this->dataFactory = $dataFactory;
        $this->items = $items;
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObject
     */
    public function createItem(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\DataObject $item
     * @return $this
     */
    public function addItem(DataObject $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param array $collectionData
     * @return $this
     */
    public function importData(array $collectionData = [])
    {
        foreach ($collectionData as $itemData) {
            $this->items[] = $this->createItem($itemData);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isAllValid()
    {
        foreach ($this->items as $item) {
            if (!$item->isValid()) {
                return false;
            }
        }
        return true;
    }
}
