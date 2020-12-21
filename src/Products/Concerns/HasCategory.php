<?php

namespace PaymentGateway\PayPalSdk\Products\Concerns;

trait HasCategory
{
    protected string $category;

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category = ''): self
    {
        $this->category = $category;

        return $this;
    }
}
