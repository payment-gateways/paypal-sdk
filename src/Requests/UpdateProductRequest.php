<?php

namespace PaymentGateway\PayPalSdk\Requests;

use PaymentGateway\PayPalSdk\Requests\Concerns\HasCategory;
use PaymentGateway\PayPalSdk\Requests\Concerns\HasDescription;
use PaymentGateway\PayPalSdk\Requests\Concerns\HasHomeUrl;
use PaymentGateway\PayPalSdk\Requests\Concerns\HasImageUrl;

class UpdateProductRequest
{
    use HasDescription;
    use HasCategory;
    use HasImageUrl;
    use HasHomeUrl;

    protected string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        $request = [];

        if ($this->description) {
            $request[] = [
                'op' => 'replace',
                'path' => '/description',
                'value' => $this->description
            ];
        }

        if ($this->category) {
            $request[] = [
                'op' => 'replace',
                'path' => '/category',
                'value' => $this->category
            ];
        }

        if ($this->imageUrl) {
            $request[] = [
                'op' => 'replace',
                'path' => '/image_url',
                'value' => $this->imageUrl
            ];
        }

        if ($this->homeUrl) {
            $request[] = [
                'op' => 'replace',
                'path' => '/home_url',
                'value' => $this->homeUrl
            ];
        }

        return $request;
    }
}
