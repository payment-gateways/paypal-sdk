<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\BillingCycles;

use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;

abstract class AbstractBillingCycle
{
    protected Frequency $frequency;

    protected PricingSchema $pricingSchema;

    protected int $sequence = 1;

    protected int $totalCycles = 1;

    public function __construct(Frequency $frequency, PricingSchema $pricingSchema)
    {
        $this->frequency = $frequency;
        $this->pricingSchema = $pricingSchema;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): void
    {
        $this->sequence = $sequence;
    }

    public function getTotalCycles(): int
    {
        return $this->totalCycles;
    }

    public function setTotalCycles(int $totalCycles): void
    {
        $this->totalCycles = $totalCycles;
    }

    abstract public function getTenureType(): string;

    public function toArray(): array
    {
        return [
            'frequency' => $this->frequency->toArray(),
            'tenure_type' => $this->getTenureType(),
            'sequence' => $this->getSequence(),
            'total_cycles' => $this->getTotalCycles(),
            'pricing_scheme' => $this->pricingSchema->toArray(),
        ];
    }
}
