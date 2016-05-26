<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractDataObjectService;

/**
 * @method \SubscribePro\Service\Customer\CustomerInterface createItem(array $data = [])
 * @method \SubscribePro\Service\Customer\CustomerInterface loadItem(int $spId)
 * @method \SubscribePro\Service\Customer\CustomerInterface saveItem(CustomerInterface $item)
 */
class CustomerService extends AbstractDataObjectService
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
     * @var string
     */
    protected $entityName = 'customer';

    /**
     * @var string
     */
    protected $entitiesName = 'customers';

    /**
     * @var string
     */
    protected $createUrl = '/v2/customer.json';

    /**
     * @var string
     */
    protected $entityUrl = '/v2/customers/%d.json';

    /**
     * @var string
     */
    protected $entitiesUrl = '/v2/customers.json';

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
        $invalidFilters = is_array($filters) ? array_diff_key($filters, array_fill_keys($this->allowedKeysForFilter, null)) : [];

        if (sizeof($invalidFilters)) {
            throw new \InvalidArgumentException('Only ['.implode(', ', $this->allowedKeysForFilter).'] query filters are allowed.');
        }

        return parent::loadItems($filters);
    }
}
