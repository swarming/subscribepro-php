<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Product\ProductInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Product\ProductInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Product\ProductInterface saveItem(ProductInterface $item)
 */
class ProductService extends AbstractService
{
    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'product';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'products';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return '/v2/product.json';
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v2/products/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v2/products.json';
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

    /**
     * @param string|null $sku
     * @return \SubscribePro\Service\Product\ProductInterface[]
     * @throws \RuntimeException
     */
    public function loadItems($sku = null)
    {
        $filters = $sku ? [ProductInterface::SKU => $sku] : [];

        return parent::loadItems($filters);
    }
}
