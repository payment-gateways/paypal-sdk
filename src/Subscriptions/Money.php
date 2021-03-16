<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class Money
{
    protected string $currencyCode;

    protected string $value;

    public function __construct(string $currencyCode, string $value)
    {
        $this->currencyCode = $currencyCode;
        $this->value = $value;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'currency_code' => $this->currencyCode,
            'value' => $this->value
        ];
    }
}
