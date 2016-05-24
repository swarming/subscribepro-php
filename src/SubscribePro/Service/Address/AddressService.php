<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\AbstractService;

class AddressService extends AbstractService
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'itemClass' => '\SubscribePro\Service\Address\Address',
        'collectionClass' => '\SubscribePro\Service\Address\AddressCollection'
    ];

    /**
     * @var string
     */
    protected $itemType = '\SubscribePro\Service\Address\Address';

    /**
     * @var string
     */
    protected $collectionType = '\SubscribePro\Service\Address\AddressCollection';

    /**
     * @param int $spId
     * @return \SubscribePro\Service\Address\Address
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/addresses/{$spId}.json");
        if (!$response) {
            return false;
        }

        $itemData = isset($response['address']) ? $response['address'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Address\Address $item
     * @param bool $changedOnly
     * @return bool|Address
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
     * @param \SubscribePro\Service\Address\Address $item
     * @param bool $changedOnly
     * @return mixed
     */
    protected function doSaveItem($item, $changedOnly = true)
    {
        $response = $this->httpClient->post(
            $this->getFormUri($item),
            ['address' => $item->getFormData($changedOnly)]
        );
        if (!$response) {
            return false;
        }
        
        $itemData = isset($response['address']) ? $response['address'] : [];
        $item->initData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Address\Address $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/address.json' : "/v2/addresses/{$item->getId()}.json";
    }

    /**
     * @param int|null $customerId
     * @return bool|\SubscribePro\Service\Address\AddressCollection
     */
    public function loadCollection($customerId = null)
    {
        $params = $customerId ? ['customer_id' => $customerId] : [];
        $response = $this->httpClient->get('/v2/addresses.json', $params);
        if (!$response) {
            return false;
        }

        $collection = $this->createCollection();
        if ($response && isset($response['addresses'])) {
            $collection->importData($response['addresses']);
        }
        return $collection;
    }
}
