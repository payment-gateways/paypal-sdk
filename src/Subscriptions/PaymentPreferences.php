<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\InitialPaymentFailureAction;

class PaymentPreferences
{
    protected Money $setupFee;

    protected bool $autoBillOutstanding = true;

    protected int $paymentFailureThreshold = 0;

    protected string $setupFeeFailureAction = InitialPaymentFailureAction::CANCEL;

    public function __construct(?Money $setupFee = null)
    {
        if ($setupFee) {
            $this->setSetupFee($setupFee);
        }
    }

    public function getSetupFee(): ?Money
    {
        return $this->setupFee ?? null;
    }

    public function setSetupFee(Money $setupFee): void
    {
        $this->setupFee = $setupFee;
    }

    public function isAutoBillOutstanding(): bool
    {
        return $this->autoBillOutstanding;
    }

    public function setAutoBillOutstanding(bool $autoBillOutstanding): void
    {
        $this->autoBillOutstanding = $autoBillOutstanding;
    }

    public function getPaymentFailureThreshold(): int
    {
        return $this->paymentFailureThreshold;
    }

    public function setPaymentFailureThreshold(int $paymentFailureThreshold): void
    {
        $this->paymentFailureThreshold = $paymentFailureThreshold;
    }

    public function getSetupFeeFailureAction(): string
    {
        return $this->setupFeeFailureAction;
    }

    public function setSetupFeeFailureAction(string $setupFeeFailureAction): void
    {
        $this->setupFeeFailureAction = $setupFeeFailureAction;
    }

    public function toArray(): array
    {
        $data =  [
            'auto_bill_outstanding' => $this->autoBillOutstanding,
            'setup_fee_failure_action' => $this->setupFeeFailureAction,
            'payment_failure_threshold' => $this->paymentFailureThreshold
        ];

        if ($this->setupFee ?? null) {
            $data['setup_fee'] = $this->setupFee->toArray();
        }

        return $data;
    }
}
