<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Address\AddressInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Address\AddressInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Address\AddressInterface saveItem(AddressInterface $item)
 */
class AddressService extends AbstractService
{
    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'address';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'addresses';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return '/v2/address.json';
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v2/addresses/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v2/addresses.json';
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new AddressFactory(
            $this->getConfigValue('itemClass', '\SubscribePro\Service\Address\Address')
        );
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
     * @param int|null $customerId
     * @return \SubscribePro\Service\Address\AddressInterface[]
     * @throws \RuntimeException
     */
    public function loadItems($customerId = null)
    {
        $filters = $customerId ? [AddressInterface::CUSTOMER_ID => $customerId] : [];

        return parent::loadItems($filters);
    }
}
