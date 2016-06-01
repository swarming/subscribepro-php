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
     * @param int|null $id
     * @return $this
     */
    public function setId($id);

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
     * @throws \InvalidArgumentException
     */
    public function getFormData();

    /**
     * @return bool
     */
    public function isValid();
}
