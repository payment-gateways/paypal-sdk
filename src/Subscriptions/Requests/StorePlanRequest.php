<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\Requests;

use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPlanDescription;
use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPlanStatus;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPaymentPreferences;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;

class StorePlanRequest
{
    use HasPlanDescription;
    use HasPlanStatus;
    use HasPaymentPreferences;

    protected string $productId;
    protected string $planName;

    protected BillingCycleSet $billingCycleSet;

    public function __construct(string $productId, string $planName, BillingCycleSet $billingCycleSet)
    {
        $this->productId = $productId;
        $this->planName = $planName;
        $this->billingCycleSet = $billingCycleSet;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getPlanName(): string
    {
        return $this->planName;
    }

    public function setPlanName(string $planName): self
    {
        $this->planName = $planName;

        return $this;
    }

    public function getBillingCycleSet(): BillingCycleSet
    {
        return $this->billingCycleSet;
    }

    public function setBillingCycleSet(BillingCycleSet $billingCycleSet): self
    {
        $this->billingCycleSet = $billingCycleSet;

        return $this;
    }

    public function toArray(): array
    {
        $request = [
            'product_id' => $this->productId,
            'name' => $this->planName,
            'billing_cycles' => $this->billingCycleSet->toArray()
        ];

        if ($this->productDescription ?? null) {
            $request['description'] = $this->planDescription;
        }

        if ($this->planStatus ?? null) {
            $request['status'] = $this->planStatus;
        }

        if (!($this->paymentPreferences ?? null)) {
            $money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, '0');
            $this->paymentPreferences = new PaymentPreferences($money);
        }

        $request['payment_preferences'] = $this->paymentPreferences->toArray();

        return $request;
    }
}
