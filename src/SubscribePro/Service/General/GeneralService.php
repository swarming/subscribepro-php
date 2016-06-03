<?php

namespace SubscribePro\Service\General;

use SubscribePro\Sdk;
use SubscribePro\Service\AbstractService;
use SubscribePro\Exception\HttpException;

class GeneralService extends AbstractService
{
    /**
     * @param \SubscribePro\Sdk $sdk
     * @return null
     */
    protected function createDataFactory(Sdk $sdk)
    {
        return null;
    }

    /**
     * @return bool
     */
    public function webhookTest()
    {
        try {
            $this->httpClient->post('/v2/webhook-test.json');
        } catch (HttpException $exception) {
            return false;
        }
        
        return true;
    }
}
