<?php

namespace Mvenghaus\OrderPrevent\Controller\Adminhtml\Rule;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Mvenghaus_OrderPrevent::default';

    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->getConfig()->getTitle()->prepend(__('Order Prevent'));

        return $resultPage;
    }
}
