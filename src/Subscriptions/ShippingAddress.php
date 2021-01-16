<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class ShippingAddress
{
    private ?ShippingDetailName $name = null;
    private ?ShippingDetailAddressPortable $address = null;

    public function getName(): ?ShippingDetailName
    {
        return $this->name;
    }

    public function setName(?ShippingDetailName $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?ShippingDetailAddressPortable
    {
        return $this->address;
    }

    public function setAddress(?ShippingDetailAddressPortable $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->name) {
            $data['name'] = $this->name->toArray();
        }

        if ($this->address) {
            $data['address'] = $this->address->toArray();
        }

        return $data;
    }
}
