<?php

namespace SubscribePro\Service\Customer;

use SubscribePro\Service\AbstractService;

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
     * @return \SubscribePro\Service\Customer\Customer
     */
    public function loadItem($spId)
    {
        $response = $this->httpClient->get("/v2/customers/{$spId}.json");
        if (!$response) {
            return false;
        }

        $itemData = isset($response['customer']) ? $response['customer'] : [];
        $item = $this->createItem($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Customer\Customer $item
     * @param bool $changedOnly
     * @return bool|Customer
     * @throws \Exception
     */
    public function saveItem($item, $changedOnly = true)
    {
        if (!$item->isValid()) {
            throw new \Exception('Not all required fields are set.');
        }

        $response = $this->httpClient->post(
            $this->getFormUri($item),
            ['customer' => $item->getFormData($changedOnly)]
        );
        if (!$response) {
            return false;
        }

        $itemData = isset($response['customer']) ? $response['customer'] : [];
        $item->initData($itemData);

        return $item;
    }

    /**
     * @param \SubscribePro\Service\Customer\Customer $item
     * @return string
     */
    protected function getFormUri($item)
    {
        return $item->isNew() ? '/v2/customer.json' : "/v2/customers/{$item->getId()}.json";
    }

    /**
     * @param array $params
     * @return Customer[]
     */
    public function loadCollection(array $params = [])
    {
        $response = $this->httpClient->get('/v2/customers.json', $params);
        if (!$response) {
            return false;
        }

        $responseData = isset($response['customers']) && is_array($response['customers']) ? $response['customers'] : [];
        return $this->createCollection($responseData);
    }
}
