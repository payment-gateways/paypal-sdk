<?php

namespace PaymentGateway\PayPalSdk\Products\Concerns;

trait HasProductDescription
{
    protected string $productDescription;

    public function getProductDescription(): string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription = ''): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }
}
