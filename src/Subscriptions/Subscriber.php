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

    public function setName(?PayerName $name): void
    {
        $this->name = $name;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function getPayerId(): ?string
    {
        return $this->payerId;
    }

    public function setPayerId(?string $payerId): void
    {
        $this->payerId = $payerId;
    }

    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    public function setPhone(?Phone $phone): void
    {
        $this->phone = $phone;
    }

    public function getShippingAddress(): ?ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?ShippingAddress $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
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
