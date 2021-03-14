<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\Requests;

use PaymentGateway\PayPalSdk\Products\Concerns\HasProductDescription;
use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPlanStatus;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\Concerns\HasPaymentPreferences;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;

class StorePlanRequest
{
    use HasProductDescription;
    use HasPlanStatus;
    use HasPaymentPreferences;

    protected string $productId;
    protected string $name;

    protected BillingCycleSet $billingCycleSet;

    public function __construct(string $productId, string $name, BillingCycleSet $billingCycleSet)
    {
        $this->productId = $productId;
        $this->name = $name;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            'name' => $this->name,
            'billing_cycles' => $this->billingCycleSet->toArray()
        ];

        if ($this->productDescription ?? null) {
            $request['description'] = $this->productDescription;
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
