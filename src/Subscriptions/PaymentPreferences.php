<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\InitialPaymentFailureAction;

class PaymentPreferences
{
    protected bool $autoBillOutstanding = true;

    protected Money $setupFee;

    protected string $setupFeeFailureAction = InitialPaymentFailureAction::CANCEL;

    protected int $paymentFailureThreshold = 0;

    public function __construct(Money $setupFee)
    {
        $this->setupFee = $setupFee;
    }

    public function toArray(): array
    {
        return [
            'auto_bill_outstanding' => $this->autoBillOutstanding,
            'setup_fee' => $this->setupFee->toArray(),
            'setup_fee_failure_action' => $this->setupFeeFailureAction,
            'payment_failure_threshold' => $this->paymentFailureThreshold
        ];
    }
}
