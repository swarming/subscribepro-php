<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractService;

/**
 * @method \SubscribePro\Service\Customer\CustomerInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Customer\CustomerInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Customer\CustomerInterface saveItem(CustomerInterface $item)
 */
class CustomerService extends AbstractService
{
    /**
     * @var string
     */
    protected $allowedKeysForFilter = [
        CustomerInterface::MAGENTO_CUSTOMER_ID,
        CustomerInterface::EMAIL,
        CustomerInterface::FIRST_NAME,
        CustomerInterface::LAST_NAME,
    ];

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'customer';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'customers';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return '/v2/customer.json';
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v2/customers/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v2/customers.json';
    }

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new CustomerFactory(
            $this->getConfigValue('itemClass', '\SubscribePro\Service\Customer\Customer')
        );
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
    public function loadItems($filters = [])
    {
        $invalidFilters = is_array($filters)
            ? array_diff_key($filters, array_fill_keys($this->allowedKeysForFilter, null))
            : [];

        if (sizeof($invalidFilters)) {
            throw new \InvalidArgumentException(
                'Only [' . implode(', ', $this->allowedKeysForFilter) . '] query filters are allowed.'
            );
        }

        return parent::loadItems($filters);
    }
}
