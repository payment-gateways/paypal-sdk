<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Plans\Concerns;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;

trait HasPaymentPreferences
{
    public function createPaymentPreferences(): PaymentPreferences
    {
        return new PaymentPreferences(
            new Money(CurrencyCode::UNITED_STATES_DOLLAR, 120)
        );
    }
}
