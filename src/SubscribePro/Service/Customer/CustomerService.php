<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractService;

class CustomerService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'customer';

    const ENTITY_NAME = 'customer';
    const ENTITIES_NAME = 'customers';

    /**
     * @var string
     */
    protected $allowedFilters = [
        CustomerInterface::MAGENTO_CUSTOMER_ID,
        CustomerInterface::EMAIL,
        CustomerInterface::FIRST_NAME,
        CustomerInterface::LAST_NAME
    ];

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataObjectFactoryInterface
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        return new CustomerFactory(
            $this->getConfigValue('instanceName', '\SubscribePro\Service\Customer\Customer')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Customer\CustomerInterface
     */
    public function createCustomer(array $data = [])
    {
        return $this->dataFactory->createItem($data);
    }

    /**
     * @param \SubscribePro\Service\Customer\CustomerInterface $item
     * @return \SubscribePro\Service\Customer\CustomerInterface
     * @throws \RuntimeException
     */
    public function saveCustomer(CustomerInterface $item)
    {
        $url = $item->isNew() ? '/v2/customer.json' : "/v2/customers/{$item->getId()}.json";
        $response = $this->httpClient->post($url, [self::ENTITY_NAME => $item->getFormData()]);
        return $this->retrieveItem($response, self::ENTITY_NAME, $item);
    }

    /**
     * @param int $customerId
     * @return \SubscribePro\Service\Customer\CustomerInterface
     * @throws \RuntimeException
     */
    public function loadCustomer($customerId)
    {
        $response = $this->httpClient->get("/v2/customers/{$customerId}.json");
        return $this->retrieveItem($response, self::ENTITY_NAME);
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
        $invalidFilters = array_diff_key($filters, array_flip($this->allowedFilters));
        if (!empty($invalidFilters)) {
            throw new \InvalidArgumentException(
                'Only [' . implode(', ', $this->allowedFilters) . '] query filters are allowed.'
            );
        }

        $response = $this->httpClient->get('/v2/customers.json', $filters);
        return $this->retrieveItems($response, self::ENTITIES_NAME);
    }
}
