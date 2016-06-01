<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\AbstractService;

class ProductService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'product';

    const ENTITY_NAME = 'product';
    const ENTITIES_NAME = 'products';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        return new ProductFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Product\Product')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function createProduct(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\Product\ProductInterface $item
     * @return \SubscribePro\Service\Product\ProductInterface
     * @throws \RuntimeException
     */
    public function saveProduct(ProductInterface $item)
    {
        $url = $item->isNew() ? '/v2/product.json' : "/v2/products/{$item->getId()}.json";
        $response = $this->httpClient->post($url, [self::ENTITY_NAME => $item->getFormData()]);
        return $this->retrieveItem($response, self::ENTITY_NAME, $item);
    }

    /**
     * @param int $productId
     * @return \SubscribePro\Service\Product\ProductInterface
     * @throws \RuntimeException
     */
    public function loadProduct($productId)
    {
        $response = $this->httpClient->get("/v2/products/{$productId}.json");
        return $this->retrieveItem($response, self::ENTITY_NAME);
    }

    /**
     * @param string|null $sku
     * @return \SubscribePro\Service\Product\ProductInterface[]
     * @throws \RuntimeException
     */
    public function loadProducts($sku = null)
    {
        $filters = $sku ? [ProductInterface::SKU => $sku] : [];
        $response = $this->httpClient->get('/v2/products.json', $filters);
        return $this->retrieveItems($response, self::ENTITIES_NAME);
    }
}
