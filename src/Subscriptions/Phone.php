<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class Phone
{
    private string $phoneNumber;
    private ?string $phoneType = null;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPhoneType(): ?string
    {
        return $this->phoneType;
    }

    public function setPhoneType(?string $phoneType): self
    {
        $this->phoneType = $phoneType;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'phone_number' => $this->phoneNumber,
        ];

        if ($this->phoneType) {
            $data['phone_type'] = $this->phoneType;
        }

        return $data;
    }
}
