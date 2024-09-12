<?php

namespace Mvenghaus\OrderPrevent\Controller\Adminhtml\Rule;

use Mvenghaus\OrderPrevent\Api\Data\RuleInterfaceFactory;
use Mvenghaus\OrderPrevent\Api\RuleRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Mvenghaus_OrderPrevent::default';

    /** @var RuleInterfaceFactory */
    private $ruleFactory;
    /** @var RuleRepositoryInterface */
    private $ruleRepository;

    /**
     * @param Action\Context $context
     * @param RuleInterfaceFactory $ruleFactory
     * @param RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        Action\Context $context,
        RuleInterfaceFactory $ruleFactory,
        RuleRepositoryInterface $ruleRepository)
    {
        parent::__construct($context);
        $this->ruleFactory = $ruleFactory;
        $this->ruleRepository = $ruleRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var \Magento\Framework\Controller\Result\Redirect $resultPage */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            if ($id) {
                $rule = $this->ruleRepository->getById($id);
            } else {
                $rule = $this->ruleFactory->create();
            }

            $request = $this->getRequest();

            $rule
                ->setCompany($request->getPost('company') ?: '*')
                ->setFirstname($request->getPost('firstname') ?: '*')
                ->setLastname($request->getPost('lastname') ?: '*')
                ->setPostcode($request->getPost('postcode') ?: '*')
                ->setCity($request->getPost('city') ?: '*')
                ->setEmail($request->getPost('email') ?: '*')
                ->setErrorMessage($request->getPost('error_message') ?: null);

            $rule = $this->ruleRepository->save($rule);

            $id = $rule->getId();

            $this->messageManager->addSuccessMessage(__('Successfully saved.'));

            $resultRedirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect;
    }
}
