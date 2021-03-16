<?php

namespace PaymentGateway\PayPalSdk\Plans\Requests;

use PaymentGateway\PayPalSdk\Plans\Concerns\HasPlanDescription;
use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPaymentPreferences;

class UpdatePlanRequest
{
    use HasPlanDescription;
    use HasPaymentPreferences;

    protected string $planId;

    public function __construct(string $planId)
    {
        $this->planId = $planId;
    }

    public function getPlanId(): string
    {
        return $this->planId;
    }

    public function setPlanId(string $planId): self
    {
        $this->planId = $planId;

        return $this;
    }

    public function toArray(): array
    {
        $request = [];

        if ($this->planDescription ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/description',
                'value' => $this->planDescription
            ];
        }

        if ($this->paymentPreferences ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/payment_preferences/auto_bill_outstanding',
                'value' => $this->paymentPreferences->isAutoBillOutstanding()
            ];
            $request[] = [
                'op' => 'replace',
                'path' => '/payment_preferences/payment_failure_threshold',
                'value' => $this->paymentPreferences->getPaymentFailureThreshold()
            ];
            $request[] = [
                'op' => 'replace',
                'path' => '/payment_preferences/setup_fee_failure_action',
                'value' => $this->paymentPreferences->getSetupFeeFailureAction()
            ];

            if ($this->paymentPreferences->getSetupFee()) {
                $request[] = [
                    'op' => 'replace',
                    'path' => '/payment_preferences/setup_fee',
                    'value' => $this->paymentPreferences->getSetupFee()->toArray()
                ];
            }
        }

        return $request;
    }
}
