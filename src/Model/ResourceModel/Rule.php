<?php

namespace Mvenghaus\OrderPrevent\Model\ResourceModel;

class Rule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('order_prevent_rules', 'id');
    }
}
