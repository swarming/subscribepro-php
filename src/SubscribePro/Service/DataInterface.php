<?php

namespace SubscribePro\Service;

interface DataInterface
{
    /**
     * @param array $data
     * @return $this
     */
    public function importData(array $data = []);

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return bool
     */
    public function isNew();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return array
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    public function getFormData();

    /**
     * @return bool
     */
    public function isValid();
}
