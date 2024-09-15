<?php

declare(strict_types=1);

namespace Mvenghaus\OrderPrevent\Model;

use Magento\Framework\Event\Manager as EventManager;
use Magento\Payment\Gateway\Command\CommandException;
use Mvenghaus\OrderPrevent\Api\Data\RuleInterface;
use Mvenghaus\OrderPrevent\Api\Data\RuleSearchResultsInterface;
use Mvenghaus\OrderPrevent\Api\RuleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Model\Order;

class OrderValidator
{
    public function __construct(
        private readonly RuleRepositoryInterface $ruleRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly EventManager $eventManager,
        private readonly Logger $logger,
    ) {
    }

    public function validate(Order $order): bool
    {
        foreach ($this->getRuleList()->getItems() as $rule) {
            $fields = array_filter(
                ['company', 'firstname', 'lastname', 'postcode', 'city', 'email'],
                function ($field) use ($rule) {
                    return !empty($rule->getData($field));
                }
            );

            if (count($fields) === 0) {
                continue;
            }

            $isValid = true;
            foreach ($fields as $field) {
                if (!$this->validateField($field, $order, $rule)) {
                    $isValid = false;
                    break;
                }
            }

            if (!$isValid) {
                $this->logger->debug(
                    implode("\n", [
                        'order_prevent_validation_failed',
                        print_r($rule->getData(), true),
                        print_r($order->getShippingAddress()->getData(), true),
                        print_r($order->getBillingAddress()->getData(), true),
                    ])
                );

                $this->eventManager->dispatch('order_prevent_validation_failed', ['order' => $order]);

                throw new CommandException(
                    __($rule->getErrorMessage() ?: 'An error occurred.')
                );
            }
        }

        return true;
    }

    public function validateField($field, Order $order, RuleInterface $rule): bool
    {
        $ruleValue = $rule->getData($field);
        $billingAddressValue = (string)$order->getBillingAddress()->getData($field);
        $shippingAddressValue = (string)$order->getShippingAddress()->getData($field);

        if (!empty($ruleValue) && (
                fnmatch($ruleValue, $billingAddressValue, FNM_CASEFOLD) ||
                fnmatch($ruleValue, $shippingAddressValue, FNM_CASEFOLD)
            )
        ) {
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
