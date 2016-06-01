<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\AbstractService;

class AddressService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'address';

    const ENTITY_NAME = 'address';
    const ENTITIES_NAME = 'addresses';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        return new AddressFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Address\Address')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function createAddress(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param int $addressId
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \RuntimeException
     */
    public function loadAddress($addressId)
    {
        $response = $this->httpClient->get("/v2/addresses/{$addressId}.json");
        return $this->retrieveItem($response, self::ENTITY_NAME);
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \RuntimeException
     */
    public function saveAddress(AddressInterface $item)
    {
        $url = $item->isNew() ? '/v2/address.json' : "/v2/addresses/{$item->getId()}.json";
        $response = $this->httpClient->post($url, [self::ENTITY_NAME => $item->getFormData()]);
        return $this->retrieveItem($response, self::ENTITY_NAME, $item);
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Address\AddressInterface[]
     * @throws \RuntimeException
     */
    public function loadAddresses($customerId = null)
    {
        $params = $customerId ? [AddressInterface::CUSTOMER_ID => $customerId] : [];
        $response = $this->httpClient->get('/v2/addresses.json', $params);
        return $this->retrieveItems($response, self::ENTITIES_NAME);
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function findOrSave($item)
    {
        $response = $this->httpClient->post('/v2/address/find-or-create.json', [self::ENTITY_NAME => $item->getFormData()]);
        return $this->retrieveItem($response, self::ENTITY_NAME, $item);
    }
}
