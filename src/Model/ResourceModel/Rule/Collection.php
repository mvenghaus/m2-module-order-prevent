<?php

namespace Mvenghaus\OrderPrevent\Model\ResourceModel\Rule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_eventPrefix = 'mvenghaus_orderprevent_rule_collection';
    protected $_eventObject = 'rule_collection';

    protected function _construct()
    {
        $this->_init(\Mvenghaus\OrderPrevent\Model\Rule::class, \Mvenghaus\OrderPrevent\Model\ResourceModel\Rule::class);
    }
}
