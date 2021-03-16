<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithAllData()
    {
        $money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, '400');

        $this->assertSame([
            'currency_code' => CurrencyCode::UNITED_STATES_DOLLAR,
            'value' => '400'
        ], $money->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, '400');

        $this->assertSame(CurrencyCode::UNITED_STATES_DOLLAR, $money->getCurrencyCode());
        $this->assertSame('400', $money->getValue());

        $money->setCurrencyCode(CurrencyCode::AUSTRALIAN_DOLLAR);
        $money->setValue('800');

        $this->assertSame(CurrencyCode::AUSTRALIAN_DOLLAR, $money->getCurrencyCode());
        $this->assertSame('800', $money->getValue());
    }
}
