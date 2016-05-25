<?php

namespace SubscribePro\Service;

interface DataObjectInterface
{

    /**
     * load data to object
     * 
     * @param array $data
     * @return $this
     */
    public function initData(array $data = []);

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
     * @param bool $changedOnly
     * @return array
     */
    public function getFormData($changedOnly = true);

    /**
     * @return bool
     */
    public function isValid();
}
