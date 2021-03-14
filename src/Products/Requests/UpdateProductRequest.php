<?php

namespace PaymentGateway\PayPalSdk\Products\Requests;

use PaymentGateway\PayPalSdk\Products\Concerns\HasProductCategory;
use PaymentGateway\PayPalSdk\Products\Concerns\HasProductDescription;
use PaymentGateway\PayPalSdk\Products\Concerns\HasHomeUrl;
use PaymentGateway\PayPalSdk\Products\Concerns\HasImageUrl;

class UpdateProductRequest
{
    use HasProductDescription;
    use HasProductCategory;
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

        if ($this->productDescription ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/description',
                'value' => $this->productDescription
            ];
        }

        if ($this->productCategory ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/category',
                'value' => $this->productCategory
            ];
        }

        if ($this->imageUrl ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/image_url',
                'value' => $this->imageUrl
            ];
        }

        if ($this->homeUrl ?? null) {
            $request[] = [
                'op' => 'replace',
                'path' => '/home_url',
                'value' => $this->homeUrl
            ];
        }

        return $request;
    }
}
