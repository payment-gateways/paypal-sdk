<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;
use PHPUnit\Framework\TestCase;

class PricingSchemaTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithAllData()
    {
        $money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, '30');
        $pricingSchema = new PricingSchema($money);

        $this->assertSame(['fixed_price' => $money->toArray()], $pricingSchema->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, '30');
        $phone = new PricingSchema($money);

        $this->assertSame($money, $phone->getFixedPrince());

        $money = new Money(CurrencyCode::AUSTRALIAN_DOLLAR, '430');
        $phone->setFixedPrince($money);

        $this->assertSame($money, $phone->getFixedPrince());
    }
}
