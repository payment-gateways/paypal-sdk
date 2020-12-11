<?php

namespace PaymentGateway\PayPalSdk\Requests\Concerns;

trait HasDescription
{
    protected string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description = ''): self
    {
        $this->description = $description;

        return $this;
    }
}
