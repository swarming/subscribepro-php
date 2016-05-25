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
     * @return \SubscribePro\Service\Product\Product
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/products/{$spId}.json");
        if (!$response) {
            return false;
        }

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

        $response = $this->httpClient->post(
            $this->getFormUri($item),
            ['product' => $item->getFormData($changedOnly)]
        );
        if (!$response) {
            return false;
        }

        $itemData = isset($response['product']) ? $response['product'] : [];
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
     * @return false|Product[]
     */
    public function loadCollection($sku = null)
    {
        $params = $sku ? ['sku' => $sku] : [];
        $response = $this->httpClient->get('/v2/products.json', $params);
        if (!$response) {
            return false;
        }

        $responseData = isset($response['products']) && is_array($response['products']) ? $response['products'] : [];
        return $this->createCollection($responseData);
    }
}
