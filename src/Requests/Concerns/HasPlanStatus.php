<?php

namespace PaymentGateway\PayPalSdk\Requests\Concerns;

trait HasPlanStatus
{
    protected string $planStatus;

    public function getPlanStatus(): string
    {
        return $this->planStatus;
    }

    public function setPlanStatus(string $planStatus): self
    {
        $this->planStatus = $planStatus;

        return $this;
    }
}
