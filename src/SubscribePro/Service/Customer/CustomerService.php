<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Customer\CustomerInterface createItem(array $data = [])
 */
class CustomerService extends AbstractService
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'itemClass' => '\SubscribePro\Service\Customer\Customer',
    ];

    /**
     * @var array
     */
    protected $staticConfig = [
        'itemType' => '\SubscribePro\Service\Customer\CustomerInterface',
    ];

    /**
     * @param int $spId
     * @return \SubscribePro\Service\Customer\CustomerInterface
     * @throws \RuntimeException
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/customers/{$spId}.json");

        $itemData = !empty($response['customer']) ? $response['customer'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Customer\CustomerInterface $item
     * @return \SubscribePro\Service\Customer\CustomerInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveItem($item)
    {
        $response = $this->httpClient->post($this->getFormUri($item), ['customer' => $item->getFormData()]);

        $itemData = isset($response['customer']) ? $response['customer'] : [];
        $item->importData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Customer\CustomerInterface $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/customer.json' : "/v2/customers/{$item->getId()}.json";
    }

    /**
     * Retrieve an array of all customers. Customers may be filtered.
     *  Available filters:
     * - magento_customer_id
     * - email
     * - first_name
     * - last_name
     *
     * @param array $filters
     * @return \SubscribePro\Service\Customer\CustomerInterface[]
     * @throws \RuntimeException
     */
    public function loadItems(array $filters = [])
    {
        $allowedKeys = ['magento_customer_id', 'email', 'first_name', 'last_name'];
        $validFilters = array_intersect_key($filters, array_fill_keys($allowedKeys, null));
        
        if (sizeof($filters) > sizeof($validFilters)) {
            throw new \InvalidArgumentException('Only ['.implode(', ', $allowedKeys).'] query filters are allowed.');
        }
        
        $response = $this->httpClient->get('/v2/customers.json', $filters);
        $responseData = !empty($response['customers']) ? $response['customers'] : [];
        
        return $this->buildList($responseData);
    }
}
