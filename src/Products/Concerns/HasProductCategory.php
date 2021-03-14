<?php

namespace PaymentGateway\PayPalSdk\Products\Concerns;

use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;

trait HasProductCategory
{
    /**
     * @var string
     * @see ProductCategory
     */
    protected string $productCategory;

    public function getProductCategory(): string
    {
        return $this->productCategory;
    }

    public function setProductCategory(string $productCategory = ''): self
    {
        $this->productCategory = $productCategory;

        return $this;
    }
}
