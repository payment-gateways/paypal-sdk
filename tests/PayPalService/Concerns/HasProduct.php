<?php

namespace PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns;

use PaymentGateway\PayPalApiMock\PayPalApiMock;
use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Constants\ProductType;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;

trait HasProduct
{
    protected function createStoreProductRequest(): StoreProductRequest
    {
        $product = new StoreProductRequest('My new product', ProductType::SERVICE);
        $product->setDescription('product description')
            ->setProductCategory(ProductCategory::SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        return $product;
    }

    protected function fakeProduct(PayPalService $service, callable $payPalApi = null): array
    {
        $payPalApi = $payPalApi ?? new PayPalApiMock();
        $service->withHandler($payPalApi);

        return $service->createProduct($this->createStoreProductRequest())->toArray();
    }
}
