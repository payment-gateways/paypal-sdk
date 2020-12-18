<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\BillingCycles;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\TenureType;

class RegularBillingCycle extends AbstractBillingCycle
{
    public const TENURE_TYPE = TenureType::REGULAR;

    public function getTenureType(): string
    {
        return self::TENURE_TYPE;
    }
}
