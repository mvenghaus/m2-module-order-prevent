<?php

namespace Mvenghaus\OrderPrevent\Controller\Adminhtml\Rule;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Mvenghaus_OrderPrevent::default';

    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Order Prevent'));

        return $resultPage;
    }
}
