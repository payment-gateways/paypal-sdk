<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\BillingCycles;

class BillingCycleSet
{
    /**
     * @var AbstractBillingCycle[]
     */
    protected array $billingCycles = [];

    public function addBillingCycle(AbstractBillingCycle $billingCycle)
    {
        $this->billingCycles[] = $billingCycle;
    }

    public function toArray(): array
    {
        $array = [];

        foreach ($this->billingCycles as $billingCycle) {
            $array[] = $billingCycle->toArray();
        }

        return $array;
    }
}
