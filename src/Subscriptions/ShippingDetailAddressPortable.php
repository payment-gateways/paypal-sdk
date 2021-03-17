<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class ShippingDetailAddressPortable
{
    private string $countryCode;
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $adminArea1 = null;
    private ?string $adminArea2 = null;
    private ?string $postalCode = null;

    public function __construct(string $countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function setAddressLine1(?string $addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setAddressLine2(?string $addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function getAdminArea1(): ?string
    {
        return $this->adminArea1;
    }

    public function setAdminArea1(?string $adminArea1): self
    {
        $this->adminArea1 = $adminArea1;

        return $this;
    }

    public function getAdminArea2(): ?string
    {
        return $this->adminArea2;
    }

    public function setAdminArea2(?string $adminArea2): self
    {
        $this->adminArea2 = $adminArea2;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'country_code' => $this->countryCode,
        ];

        if ($this->addressLine1) {
            $data['address_line_1'] = $this->addressLine1;
        }

        if ($this->addressLine2) {
            $data['address_line_2'] = $this->addressLine2;
        }

        if ($this->adminArea1) {
            $data['admin_area_1'] = $this->adminArea1;
        }

        if ($this->adminArea2) {
            $data['admin_area_2'] = $this->adminArea2;
        }

        if ($this->postalCode) {
            $data['postal_code'] = $this->postalCode;
        }

        return $data;
    }
}
