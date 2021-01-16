<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class ShippingDetailName
{
    private ?string $fullName = null;

    public function __construct(?string $fullName)
    {
        $this->fullName = $fullName;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName
        ];
    }
}
