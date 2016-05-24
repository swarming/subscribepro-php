<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\AbstractService;

class ProductService extends AbstractService
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'itemClass' => '\SubscribePro\Service\Product\Product',
        'collectionClass' => '\SubscribePro\Service\Product\ProductCollection'
    ];

    /**
     * @var string
     */
    protected $itemType = '\SubscribePro\Service\Product\Product';

    /**
     * @var string
     */
    protected $collectionType = '\SubscribePro\Service\Product\ProductCollection';

    /**
     * @param int $spId
     * @return \SubscribePro\Service\Product\Product
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/products/{$spId}.json");

        $itemData = !empty($response['product']) ? $response['product'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Product\Product $item
     * @param bool $changedOnly
     * @return bool|Product
     * @throws \Exception
     */
    public function saveItem($item, $changedOnly = true)
    {
        if (!$item->isValid()) {
            throw new \Exception('Not all required fields are set.');
        }
        
        return $this->doSaveItem($item, $changedOnly);
    }

    /**
     * @param \SubscribePro\Service\Product\Product $item
     * @param bool $changedOnly
     * @return mixed
     */
    protected function doSaveItem($item, $changedOnly = true)
    {
        $response = $this->httpClient->post(
            $this->getFormUri($item),
            ['product' => $item->getFormData($changedOnly)]
        );

        $itemData = !empty($response['product']) ? $response['product'] : [];
        $item->initData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Product\Product $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/product.json' : "/v2/products/{$item->getId()}.json";
    }

    /**
     * @param string|null $sku
     * @return \SubscribePro\Service\DataCollection
     */
    public function loadCollection($sku = null)
    {
        $params = $sku ? ['sku' => $sku] : [];
        $response = $this->httpClient->get('/v2/products.json', $params);

        $collection = $this->createCollection();
        if ($response && !empty($response['products'])) {
            $collection->importData($response['products']);
        }
        return $collection;
    }

    /**
     * @param \SubscribePro\Service\DataCollection $collection
     * @param bool $changedOnly
     * @return \SubscribePro\Service\DataCollection
     * @throws \Exception
     */
    public function saveCollection($collection, $changedOnly = true)
    {
        if (!$collection->isValid()) {
            throw new \Exception('Not all required fields are set in one or more items.');
        }

        foreach ($collection as $item) {
            $this->doSaveItem($item, $changedOnly);
        }
        
        return $collection;
    }
}
