<?php

namespace Mvenghaus\OrderPrevent\Controller\Adminhtml\Rule;

use Magento\Framework\Controller\ResultFactory;

class Add extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Mvenghaus_OrderPrevent::default';

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);

        return $resultForward->forward('edit');
    }
}
