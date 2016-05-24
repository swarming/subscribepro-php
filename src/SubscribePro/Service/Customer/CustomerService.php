<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractService;

class CustomerService extends AbstractService
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'itemClass' => '\SubscribePro\Service\Customer\Customer',
        'collectionClass' => '\SubscribePro\Service\Customer\CustomerCollection'
    ];

    /**
     * @var string
     */
    protected $itemType = '\SubscribePro\Service\Customer\Customer';

    /**
     * @var string
     */
    protected $collectionType = '\SubscribePro\Service\Customer\CustomerCollection';

    /**
     * @param int $spId
     * @return \SubscribePro\Service\Customer\Customer
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/customers/{$spId}.json");
        if (!$response) {
            return false;
        }

        $itemData = isset($response['customer']) ? $response['customer'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Customer\Customer $item
     * @param bool $changedOnly
     * @return bool|Customer
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
     * @param \SubscribePro\Service\Customer\Customer $item
     * @param bool $changedOnly
     * @return mixed
     */
    protected function doSaveItem($item, $changedOnly = true)
    {
        $response = $this->httpClient->post(
            $this->getFormUri($item),
            ['customer' => $item->getFormData($changedOnly)]
        );
        if (!$response) {
            return false;
        }
        
        $itemData = isset($response['customer']) ? $response['customer'] : [];
        $item->initData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Customer\Customer $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/customer.json' : "/v2/customers/{$item->getId()}.json";
    }

    /**
     * @param array $params
     * @return \SubscribePro\Service\DataCollection
     */
    public function loadCollection(array $params = [])
    {
        $response = $this->httpClient->get('/v2/customers.json', $params);
        if (!$response) {
            return false;
        }

        $collection = $this->createCollection();
        if ($response && !isset($response['customers'])) {
            $collection->importData($response['customers']);
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

        foreach ($collection->getItems() as $item) {
            $this->doSaveItem($item, $changedOnly);
        }
        
        return $collection;
    }
}
