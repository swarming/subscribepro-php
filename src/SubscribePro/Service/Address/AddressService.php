<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Address\AddressInterface createItem(array $data = [])
 */
class AddressService extends AbstractService
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'itemClass' => '\SubscribePro\Service\Address\Address',
    ];

    /**
     * @var array
     */
    protected $staticConfig = [
        'itemType' => '\SubscribePro\Service\Address\AddressInterface',
    ];

    /**
     * @param int $spId
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \RuntimeException
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/addresses/{$spId}.json");

        $itemData = !empty($response['address']) ? $response['address'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getFormUri($item), ['address' => $item->getFormData()]);

        $itemData = !empty($response['address']) ? $response['address'] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function findOrSave($item)
    {
        $response = $this->httpClient->post('/v2/address/find-or-create.json', ['address' => $item->getFormData()]);

        $itemData = isset($response['address']) ? $response['address'] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/address.json' : "/v2/addresses/{$item->getId()}.json";
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Address\AddressInterface[]
     * @throws \RuntimeException
     */
    public function loadItems($customerId = null)
    {
        $params = $customerId ? ['customer_id' => $customerId] : [];
        $response = $this->httpClient->get('/v2/addresses.json', $params);

        $responseData = !empty($response['addresses']) ? $response['addresses'] : [];
        return $this->buildList($responseData);
    }
}
