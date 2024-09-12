<?php
declare(strict_types=1);

namespace Mvenghaus\OrderPrevent\Model;

use Mvenghaus\OrderPrevent\Api\Data\RuleInterface;
use Mvenghaus\OrderPrevent\Api\Data\RuleSearchResultsInterface;
use Mvenghaus\OrderPrevent\Api\RuleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Model\Order;

class OrderValidator
{
    private RuleRepositoryInterface $ruleRepository;
    private SearchCriteriaBuilder   $searchCriteriaBuilder;

    /**
     * @param RuleRepositoryInterface $ruleRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        RuleRepositoryInterface $ruleRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder)
    {
        $this->ruleRepository = $ruleRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function validate(Order $order): bool
    {
        if ($order->getBillingAddress() && preg_match('/\.1121@/i', $order->getBillingAddress()->getEmail())) {
            throw new \Magento\Payment\Gateway\Command\CommandException(
                __('An error occurred.')
            );
        }

        foreach ($this->getRuleList()->getItems() as $rule) {
            $fields = array_filter(
                ['company', 'firstname', 'lastname', 'postcode', 'city', 'email'],
                function ($field) use ($rule) {
                    return ($rule->getData($field) !== '*');
                }
            );

            if (count($fields) === 0) {
                continue;
            }

            $isValid = false;
            foreach ($fields as $field) {
                if ($this->validateField($field, $order, $rule)) {
                    $isValid = true;
                    break;
                }
            }

            if (!$isValid) {
                throw new \Magento\Payment\Gateway\Command\CommandException(
                    __($rule->getErrorMessage() ?: 'An error occurred.')
                );
            }
        }

        return true;
    }

    private function validateField($field, Order $order, RuleInterface $rule): bool
    {
        $ruleValue = mb_strtolower((string)  $rule->getData($field), 'UTF-8');
        if (!$ruleValue) {
            return true;
        }

        if (mb_strtolower((string) $order->getBillingAddress()->getData($field), 'UTF-8') == $ruleValue) {
            return false;
        }
        if (!$order->getIsVirtual()
            && mb_strtolower((string) $order->getShippingAddress()->getData($field), 'UTF-8') == $ruleValue) {
            return false;
        }

        return true;
    }

    private function getRuleList(): RuleSearchResultsInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->ruleRepository->getList($searchCriteria);
    }
}
