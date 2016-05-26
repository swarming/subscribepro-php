<?php

namespace SubscribePro\Service\Product;

use SubscribePro\Service\AbstractDataObjectService;

/**
 * @method \SubscribePro\Service\Product\ProductInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Product\ProductInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Product\ProductInterface saveItem(ProductInterface $item)
 */
class ProductService extends AbstractDataObjectService
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
     * @var string
     */
    protected $entityName = 'product';

    /**
     * @var string
     */
    protected $entitiesName = 'products';

    /**
     * @var string
     */
    protected $createUrl = '/v2/product.json';

    /**
     * @var string
     */
    protected $entityUrl = '/v2/products/%d.json';

    /**
     * @var string
     */
    protected $entitiesUrl = '/v2/products.json';

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
