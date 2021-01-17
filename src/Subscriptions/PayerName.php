<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class PayerName
{
    private ?string $givenName = null;
    private ?string $surname = null;

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(?string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->givenName) {
            $data['given_name'] = $this->givenName;
        }

        if ($this->surname) {
            $data['surname'] = $this->surname;
        }

        return $data;
    }
}
