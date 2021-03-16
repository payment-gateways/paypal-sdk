<?php

namespace PaymentGateway\PayPalSdk\Plans\Requests;

use PaymentGateway\PayPalSdk\Products\Concerns\HasProductDescription;
use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPaymentPreferences;

class UpdatePlanRequest
{
    use HasProductDescription;
    use HasPaymentPreferences;

    protected string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        $request = [];

        if ($this->productDescription ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/description',
                'value' => $this->productDescription
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
