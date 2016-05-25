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
    ];

    /**
     * @var array
     */
    protected $staticConfig = [
        'itemType' => '\SubscribePro\Service\Product\ProductInterface',
    ];

    /**
     * @param int $spId
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/products/{$spId}.json");

        $itemData = !empty($response['product']) ? $response['product'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Product\ProductInterface $item
     * @return \SubscribePro\Service\Product\ProductInterface
     * @throws \InvalidArgumentException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getFormUri($item), ['product' => $item->getFormData()]);

        $itemData = !empty($response['product']) ? $response['product'] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Product\ProductInterface $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/product.json' : "/v2/products/{$item->getId()}.json";
    }

    /**
     * @param string|null $sku
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function loadList($sku = null)
    {
        $params = $sku ? ['sku' => $sku] : [];
        $response = $this->httpClient->get('/v2/products.json', $params);

        $responseData = !empty($response['products']) ? $response['products'] : [];
        return $this->buildList($responseData);
    }
}
