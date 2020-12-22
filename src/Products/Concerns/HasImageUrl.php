<?php

namespace PaymentGateway\PayPalSdk\Products\Concerns;

trait HasImageUrl
{
    protected string $imageUrl;

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl = ''): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
