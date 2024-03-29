<?php

namespace PaymentGateway\PayPalSdk\Products\Requests;

use PaymentGateway\PayPalSdk\Products\Concerns\HasProductCategory;
use PaymentGateway\PayPalSdk\Products\Concerns\HasProductDescription;
use PaymentGateway\PayPalSdk\Products\Concerns\HasHomeUrl;
use PaymentGateway\PayPalSdk\Products\Concerns\HasImageUrl;
use PaymentGateway\PayPalSdk\Products\Constants\ProductType;

class StoreProductRequest
{
    use HasProductDescription;
    use HasProductCategory;
    use HasImageUrl;
    use HasHomeUrl;

    /**
     * The ID of the product.
     * 
     * You can specify the SKU for the product. If you omit the ID, the system generates it.
     * System-generated IDs have the PROD- prefix.
     * 
     * @var string
     */
    protected string $productId;

    protected string $productName;

    /**
     * @var string
     * @see ProductType
     */
    protected string $productType;

    public function __construct(string $productName, string $productType)
    {
        $this->productName = $productName;
        $this->productType = $productType;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    public function toArray(): array
    {
        $request = [];

        if ($this->productId ?? null) {
            $request['id'] = $this->productId;
        }

        $request['name'] = $this->productName;
        $request['type'] = $this->productType;

        if ($this->productDescription ?? null) {
            $request['description'] = $this->productDescription;
        }

        if ($this->productCategory ?? null) {
            $request['category'] = $this->productCategory;
        }

        if ($this->imageUrl ?? null) {
            $request['image_url'] = $this->imageUrl;
        }

        if ($this->homeUrl ?? null) {
            $request['home_url'] = $this->homeUrl;
        }

        return $request;
    }
}
