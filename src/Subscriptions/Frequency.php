<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class Frequency
{
    protected string $frequency;
    protected int $quantity;

    public function __construct(string $frequency, int $quantity)
    {
        $this->frequency = $frequency;
        $this->quantity = $quantity;
    }

    public function getFrequency(): string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): void
    {
        $this->frequency = $frequency;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function toArray(): array
    {
        return [
            'interval_unit' => $this->frequency,
            'interval_count' => $this->quantity,
        ];
    }
}
