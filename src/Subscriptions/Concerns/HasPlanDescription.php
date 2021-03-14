<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\Concerns;

trait HasPlanDescription
{
    protected string $planDescription;

    public function getPlanDescription(): string
    {
        return $this->planDescription;
    }

    public function setPlanDescription(string $planDescription): self
    {
        $this->planDescription = $planDescription;

        return $this;
    }
}
