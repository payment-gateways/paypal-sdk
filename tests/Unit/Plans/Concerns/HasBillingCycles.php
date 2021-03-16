<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Plans\Concerns;

use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\RegularBillingCycle;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\IntervalUnit;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;

trait HasBillingCycles
{
    public function createBillingCycleSet(): BillingCycleSet
    {
        $frequency = new Frequency(IntervalUnit::MONTH, mt_rand(1, 12));
        $pricingSchema = new PricingSchema(new Money(CurrencyCode::UNITED_STATES_DOLLAR, mt_rand(0, 1000)));
        $billingCycle = new RegularBillingCycle($frequency, $pricingSchema);
        $billingCycleSet = new BillingCycleSet();
        $billingCycleSet->addBillingCycle($billingCycle);

        return $billingCycleSet;
    }
}
