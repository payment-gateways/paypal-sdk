<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class ShippingDetail
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
        return [
            ''
        ];
    }
}
