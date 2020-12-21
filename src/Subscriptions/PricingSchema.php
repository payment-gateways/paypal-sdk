<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class PricingSchema
{
    protected Money $fixedPrince;

    public function __construct(Money $fixedPrice)
    {
        $this->fixedPrince = $fixedPrice;
    }

    public function getFixedPrince(): Money
    {
        return $this->fixedPrince;
    }

    public function setFixedPrince(Money $fixedPrince): void
    {
        $this->fixedPrince = $fixedPrince;
    }

    public function toArray(): array
    {
        return [
            'fixed_price' => $this->fixedPrince->toArray()
        ];
    }
}
