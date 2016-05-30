<?php

namespace SubscribePro\Service\Token;

use SubscribePro\Service\DataObjectFactoryInterface;

interface TokenFactoryInterface extends DataObjectFactoryInterface
{
    /**
     * @param array $data
     * @return \SubscribePro\Service\PaymentProfile\PaymentProfileInterface
     */
    public function createPaymentProfileItem(array $data = []);
}
