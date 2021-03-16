<?php

namespace PaymentGateway\PayPalSdk\Plans\Concerns;

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
