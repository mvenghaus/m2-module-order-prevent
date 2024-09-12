<?php

namespace Mvenghaus\OrderPrevent\Controller\Adminhtml\Rule;

use Mvenghaus\OrderPrevent\Api\RuleRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Mvenghaus_OrderPrevent::default';

    /** @var RuleRepositoryInterface */
    private $ruleRepository;

    /**
     * @param Action\Context $context
     * @param RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        Action\Context $context,
        RuleRepositoryInterface $ruleRepository)
    {
        parent::__construct($context);
        $this->ruleRepository = $ruleRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        try {
            $rule = $this->ruleRepository->getById($id);

            $this->ruleRepository->delete($rule);

            $this->messageManager->addSuccessMessage(__('Successfully deleted.'));
            ;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Framework\Controller\Result\Redirect $resultPage */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $resultRedirect->setPath('*/*/index');

        return $resultRedirect;
    }
}
