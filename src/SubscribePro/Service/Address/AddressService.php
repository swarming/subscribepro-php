<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\AbstractService;

class AddressService extends AbstractService
{
    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new AddressFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Address\Address')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function createAddress(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param $id
     * @throws \RuntimeException
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function loadAddress($id)
    {
        return $this->loadItem("/v2/addresses/{$id}.json", 'address');
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \RuntimeException
     */
    public function saveAddress(AddressInterface $item)
    {
        return $this->saveItem($item, '/v2/address.json', "/v2/addresses/{$item->getId()}.json", 'address');
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Address\AddressInterface[]
     * @throws \RuntimeException
     */
    public function loadAddresses($customerId = null)
    {
        $filters = $customerId ? [AddressInterface::CUSTOMER_ID => $customerId] : [];

        return $this->loadItems($filters, '/v2/addresses.json', 'addresses');
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
}
