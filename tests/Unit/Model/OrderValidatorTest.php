<?php

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Address;
use Mvenghaus\OrderPrevent\Model\OrderValidator;
use Mvenghaus\OrderPrevent\Model\Rule;
use PHPUnit\Framework\TestCase;

class OrderValidatorTest extends TestCase
{
    private OrderValidator $orderValidator;

    protected function setUp(): void
    {
        $this->orderValidator = $this->createPartialMock(OrderValidator::class, []);
    }

    /**
     * @dataProvider testValidateFieldDataProvider
     * @return void
     */
    public function testValidateField(
        string $billingAddressValue,
        string $shippingAddressValue,
        string $ruleValue,
        bool $expected
    ): void {
        $billingAddress = $this->createMock(Address::class);
        $billingAddress->expects($this->any())->method('getData')->willReturn($billingAddressValue);

        $shippingAddress = $this->createMock(Address::class);
        $shippingAddress->expects($this->any())->method('getData')->willReturn($shippingAddressValue);

        $order = $this->createMock(Order::class);
        $order->expects($this->any())->method('getBillingAddress')->willReturn($billingAddress);
        $order->expects($this->any())->method('getShippingAddress')->willReturn($shippingAddress);

        $rule = $this->createMock(Rule::class);
        $rule->expects($this->any())->method('getData')->willReturn($ruleValue);

        $this->assertSame($expected, $this->orderValidator->validateField('dummy', $order, $rule));
    }

    public function testValidateFieldDataProvider(): array
    {
        return [
            ['', '', '', true],
            ['test@blocked.com', 'test@allowed.com', '', true],
            ['test@blocked.com', 'test@allowed.com', 'blocked', true],
            ['test@blocked.com', 'test@allowed.com', '*blocked', true],
            ['', '', '*', false],
            ['test@blocked.com', 'test@allowed.com', 'test@blocked.com', false],
            ['test@blocked.com', 'test@allowed.com', '*blocked*', false],
            ['test@blocked.com', 'test@allowed.com', '*', false],
        ];
    }
}