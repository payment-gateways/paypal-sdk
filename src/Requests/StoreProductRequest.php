<?php

namespace PaymentGateway\PayPalSdk\Requests;

use PaymentGateway\PayPalSdk\Requests\Concerns\HasCategory;
use PaymentGateway\PayPalSdk\Requests\Concerns\HasDescription;
use PaymentGateway\PayPalSdk\Requests\Concerns\HasHomeUrl;
use PaymentGateway\PayPalSdk\Requests\Concerns\HasImageUrl;

class StoreProductRequest
{
    use HasDescription;
    use HasCategory;
    use HasImageUrl;
    use HasHomeUrl;

    protected string $name;
    protected string $type;

    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        $request = [
            'name' => $this->name,
            'type' => $this->type,
        ];

        if ($this->description) {
            $request['description'] = $this->description;
        }

        if ($this->category) {
            $request['category'] = $this->category;
        }

        if ($this->imageUrl) {
            $request['image_url'] = $this->imageUrl;
        }

        if ($this->homeUrl) {
            $request['home_url'] = $this->homeUrl;
        }

        return $request;
    }
}
