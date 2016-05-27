<?php

namespace SubscribePro\Service\PaymentProfile;

use SubscribePro\Service\AbstractService;

class PaymentProfileService extends AbstractService
{
    /**
     * @param \SubscribePro\Sdk $sdk
     */
    protected function createDataFactory(\SubscribePro\Sdk $sdk)
    {
        $this->dataFactory = new PaymentProfileFactory(
            $sdk->getAddressService()->getDataFactory(),
            $this->getConfigValue('itemClass', '\SubscribePro\Service\PaymentProfile\PaymentProfile')
        );
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'paymentprofile';
    }

    /**
     * @return string
     */
    protected function getEntitiesName()
    {
        return 'paymentprofiles';
    }

    /**
     * @return string
     */
    protected function getCreateUrl()
    {
        return '/v1/vault/paymentprofile.json';
    }

    /**
     * @param string $id
     * @return string
     */
    protected function getEntityUrl($id)
    {
        return "/v1/vault/paymentprofiles/{$id}.json";
    }

    /**
     * @return string
     */
    protected function getEntitiesUrl()
    {
        return '/v1/vault/paymentprofiles.json';
    }
}
