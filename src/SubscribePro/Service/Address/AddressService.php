<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Sdk;
use SubscribePro\Service\AbstractService;

class AddressService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'address';

    const API_NAME_ADDRESS = 'address';
    const API_NAME_ADDRESSES = 'addresses';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataFactoryInterface
     */
    protected function createDataFactory(Sdk $sdk)
    {
        return new AddressFactory(
            $this->getConfigValue(self::CONFIG_INSTANCE_NAME, '\SubscribePro\Service\Address\Address')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Address\AddressInterface
     */
    public function createAddress(array $data = [])
    {
        return $this->dataFactory->create($data);
    }

    /**
     * @param int $addressId
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \SubscribePro\Exception\HttpException
     */
    public function loadAddress($addressId)
    {
        $response = $this->httpClient->get("/v2/addresses/{$addressId}.json");
        return $this->retrieveItem($response, self::API_NAME_ADDRESS);
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \SubscribePro\Exception\HttpException
     */
    public function saveAddress(AddressInterface $item)
    {
        $url = $item->isNew() ? '/v2/address.json' : "/v2/addresses/{$item->getId()}.json";
        $response = $this->httpClient->post($url, [self::API_NAME_ADDRESS => $item->getFormData()]);
        return $this->retrieveItem($response, self::API_NAME_ADDRESS, $item);
    }

    /**
     * @param \SubscribePro\Service\Address\AddressInterface $item
     * @return \SubscribePro\Service\Address\AddressInterface
     * @throws \SubscribePro\Exception\InvalidArgumentException
     * @throws \SubscribePro\Exception\HttpException
     */
    public function findOrSave($item)
    {
        $response = $this->httpClient->post('/v2/address/find-or-create.json', [self::API_NAME_ADDRESS => $item->getFormData()]);
        return $this->retrieveItem($response, self::API_NAME_ADDRESS, $item);
    }

    /**
     * @param int|null $customerId
     * @return \SubscribePro\Service\Address\AddressInterface[]
     * @throws \SubscribePro\Exception\HttpException
     */
    public function loadAddresses($customerId = null)
    {
        $params = $customerId ? [AddressInterface::CUSTOMER_ID => $customerId] : [];
        $response = $this->httpClient->get('/v2/addresses.json', $params);
        return $this->retrieveItems($response, self::API_NAME_ADDRESSES);
    }
}
