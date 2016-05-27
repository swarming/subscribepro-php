<?php

namespace SubscribePro\Service;

interface DataObjectFactoryInterface
{
    /**
     * @param array $data
     * @return \SubscribePro\Service\DataObject
     */
    public function createItem(array $data = []);
}
