<?php

namespace SubscribePro\Service\Address;

use SubscribePro\Service\AbstractDataObjectService;

/**
 * @method \SubscribePro\Service\Address\AddressInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Address\AddressInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Address\AddressInterface saveItem(AddressInterface $item)
 */
class AddressService extends AbstractDataObjectService
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
     * @var string
     */
    protected $entityName = 'address';

    /**
     * @var string
     */
    protected $entitiesName = 'addresses';

    /**
     * @var string
     */
    protected $createUrl = '/v2/address.json';

    /**
     * @var string
     */
    protected $entityUrl = '/v2/addresses/%d.json';

    /**
     * @var string
     */
    protected $entitiesUrl = '/v2/addresses.json';

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
