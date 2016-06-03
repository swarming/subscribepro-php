<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Sdk;
use SubscribePro\Service\AbstractService;

class ProductService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'product';

    const API_NAME_PRODUCT = 'product';
    const API_NAME_PRODUCTS = 'products';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataFactoryInterface
     */
    protected function createDataFactory(Sdk $sdk)
    {
        return new ProductFactory(
            $this->getConfigValue(Sdk::CONFIG_INSTANCE_NAME, '\SubscribePro\Service\Product\Product')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function createProduct(array $data = [])
    {
        return $this->dataFactory->create($data);
    }

    /**
     * @param \SubscribePro\Service\Product\ProductInterface $item
     * @return \SubscribePro\Service\Product\ProductInterface
     * @throws \SubscribePro\Exception\HttpException
     */
    public function saveProduct(ProductInterface $item)
    {
        $url = $item->isNew() ? '/v2/product.json' : "/v2/products/{$item->getId()}.json";
        $response = $this->httpClient->post($url, [self::API_NAME_PRODUCT => $item->getFormData()]);
        return $this->retrieveItem($response, self::API_NAME_PRODUCT, $item);
    }

    /**
     * @param int $productId
     * @return \SubscribePro\Service\Product\ProductInterface
     * @throws \SubscribePro\Exception\HttpException
     */
    public function loadProduct($productId)
    {
        $response = $this->httpClient->get("/v2/products/{$productId}.json");
        return $this->retrieveItem($response, self::API_NAME_PRODUCT);
    }

    /**
     * @param string|null $sku
     * @return \SubscribePro\Service\Product\ProductInterface[]
     * @throws \SubscribePro\Exception\HttpException
     */
    public function loadProducts($sku = null)
    {
        $filters = !empty($sku) ? [ProductInterface::SKU => $sku] : [];
        $response = $this->httpClient->get('/v2/products.json', $filters);
        return $this->retrieveItems($response, self::API_NAME_PRODUCTS);
    }
}
