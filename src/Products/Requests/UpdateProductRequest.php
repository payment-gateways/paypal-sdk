<?php

namespace PaymentGateway\PayPalSdk\Products\Requests;

use PaymentGateway\PayPalSdk\Products\Concerns\HasCategory;
use PaymentGateway\PayPalSdk\Products\Concerns\HasDescription;
use PaymentGateway\PayPalSdk\Products\Concerns\HasHomeUrl;
use PaymentGateway\PayPalSdk\Products\Concerns\HasImageUrl;

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
