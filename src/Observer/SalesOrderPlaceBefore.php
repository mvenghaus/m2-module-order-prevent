<?php

namespace Mvenghaus\OrderPrevent\Observer;

use Braintree\Exception;
use Mvenghaus\OrderPrevent\Model\OrderValidator;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SalesOrderPlaceBefore implements ObserverInterface
{
    /** @var OrderValidator */
    private $orderValidator;

    /**
     * @param OrderValidator $orderValidator
     */
    public function __construct(OrderValidator $orderValidator)
    {
        $this->orderValidator = $orderValidator;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Magento\Payment\Gateway\Command\CommandException
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getOrder();

        $this->orderValidator->validate($order);
    }
}
