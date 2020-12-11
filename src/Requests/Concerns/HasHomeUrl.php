<?php

namespace PaymentGateway\PayPalSdk\Requests\Concerns;

trait HasHomeUrl
{
    protected string $homeUrl;

    public function getHomeUrl(): string
    {
        return $this->homeUrl;
    }

    public function setHomeUrl(string $homeUrl = ''): self
    {
        $this->homeUrl = $homeUrl;

        return $this;
    }
}
