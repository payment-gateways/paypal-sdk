<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class Subscriber
{
    private ?PayerName $name = null;
    private ?string $emailAddress = null;
    private ?string $payerId = null;
    private ?Phone $phone = null;
    private ?ShippingAddress $shippingAddress = null;

    public function getName(): ?PayerName
    {
        return $this->name;
    }

    public function setName(?PayerName $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPayerId(): ?string
    {
        return $this->payerId;
    }

    public function setPayerId(?string $payerId): self
    {
        $this->payerId = $payerId;

        return $this;
    }

    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    public function setPhone(?Phone $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getShippingAddress(): ?ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?ShippingAddress $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->name) {
            $data['name'] = $this->name->toArray();
        }

        if ($this->emailAddress) {
            $data['email_address'] = $this->emailAddress;
        }

        if ($this->payerId) {
            $data['payer_id'] = $this->payerId;
        }

        if ($this->phone) {
            $data['phone'] = $this->phone->toArray();
        }

        if ($this->shippingAddress) {
            $data['shipping_address'] = $this->shippingAddress->toArray();
        }

        return $data;
    }
}
