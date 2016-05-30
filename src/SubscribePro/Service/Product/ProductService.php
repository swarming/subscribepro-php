<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\AbstractService;

class ProductService extends AbstractService
{
    /**
     * @param array $data
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function createProduct(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\Product\ProductInterface $item
     * @return \SubscribePro\Service\Product\ProductInterface
     * @throws \RuntimeException
     */
    public function saveProduct(ProductInterface $item)
    {
        return $this->saveItem($item, '/v2/product.json', "/v2/products/{$item->getId()}.json", 'product');
    }

    /**
     * @param $id
     * @throws \RuntimeException
     * @return \SubscribePro\Service\Product\ProductInterface
     */
    public function loadProduct($id)
    {
        return $this->loadItem("/v2/products/{$id}.json", 'product');
    }

    /**
     * @param string|null $sku
     * @return \SubscribePro\Service\Product\ProductInterface[]
     * @throws \RuntimeException
     */
    public function loadProducts($sku = null)
    {
        $filters = $sku ? [ProductInterface::SKU => $sku] : [];

        return $this->loadItems($filters, '/v2/products.json', 'products');
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new ProductFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Product\Product')
        );
    }
}
