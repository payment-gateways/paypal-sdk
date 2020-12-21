<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\BillingCycles;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\TenureType;

class TrialBillingCycle extends AbstractBillingCycle
{
    public const TENURE_TYPE = TenureType::TRIAL;

    public function getTenureType(): string
    {
        return self::TENURE_TYPE;
    }
}
