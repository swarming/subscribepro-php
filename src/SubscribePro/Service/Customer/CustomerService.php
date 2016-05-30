<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractService;

class CustomerService extends AbstractService
{
    /**
     * @var string
     */
    protected $allowedKeysForFilter = [
        CustomerInterface::MAGENTO_CUSTOMER_ID,
        CustomerInterface::EMAIL,
        CustomerInterface::FIRST_NAME,
        CustomerInterface::LAST_NAME
    ];

    /**
     * @param array $data
     * @return \SubscribePro\Service\Customer\CustomerInterface
     */
    public function createCustomer(array $data = [])
    {
        return $this->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\Customer\CustomerInterface $item
     * @return \SubscribePro\Service\Customer\CustomerInterface
     * @throws \RuntimeException
     */
    public function saveCustomer(CustomerInterface $item)
    {
        return $this->saveItem($item, '/v2/customer.json', "/v2/customers/{$item->getId()}.json", 'customer');
    }

    /**
     * @param $id
     * @throws \RuntimeException
     * @return \SubscribePro\Service\Customer\CustomerInterface
     */
    public function loadCustomer($id)
    {
        return $this->loadItem("/v2/customers/{$id}.json", 'customer');
    }

    /**
     * Retrieve an array of all customers. Customers may be filtered.
     *  Available filters:
     * - magento_customer_id
     * - email
     * - first_name
     * - last_name
     *
     * @param array|null $filters
     * @return \SubscribePro\Service\Customer\CustomerInterface[]
     * @throws \RuntimeException
     */
    public function loadCustomers(array $filters = [])
    {
        $invalidFilters = array_diff_key($filters, array_flip($this->allowedKeysForFilter));
        if (!empty($invalidFilters)) {
            throw new \InvalidArgumentException(
                'Only [' . implode(', ', $this->allowedKeysForFilter) . '] query filters are allowed.'
            );
        }

        return $this->loadItems($filters, '/v2/customers.json', 'customers');
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new CustomerFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Customer\Customer')
        );
    }
}
