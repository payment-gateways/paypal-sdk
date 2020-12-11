<p align="center"><img src="https://blog.pleets.org/img/articles/paypal-sdk.png" height="150"></p>

<p align="center">
<a href="https://travis-ci.com/payment-gateways/paypal-sdk"><img src="https://travis-ci.com/payment-gateways/paypal-sdk.svg?branch=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/payment-gateways/paypal-sdk"><img src="https://img.shields.io/scrutinizer/g/payment-gateways/paypal-sdk.svg" alt="Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/payment-gateways/paypal-sdk/?branch=master"><img src="https://scrutinizer-ci.com/g/payment-gateways/paypal-sdk/badges/coverage.png?b=master" alt="Code Coverage"></a>
</p>

# PayPal SDK

This is a lightweight SDK for [PayPal REST APIS](https://developer.paypal.com/docs/api/overview/).

<a href="https://sonarcloud.io/dashboard?id=payment-gateways_paypal-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=payment-gateways_paypal-sdk&metric=security_rating" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=payment-gateways_paypal-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=payment-gateways_paypal-sdk&metric=bugs" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=payment-gateways_paypal-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=payment-gateways_paypal-sdk&metric=code_smells" alt="Bugs"></a>

# Installation

Use following command to install this library:

```bash
composer require payment-gateways/paypal-sdk
```

# Usage

## Catalog products API

Merchants can use the Catalog Products API to create products, which are goods and services.

### List products

To get all products use the `getProducts` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getProducts()->parseJson();
```

### Create a product

To create a product use the `createProduct` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Constants\ProductType;
use PaymentGateway\PayPalSdk\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Requests\StoreProductRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$product = new StoreProductRequest('My new product', ProductType::SERVICE);
$product->setDescription('product description')
    ->setCategory(ProductCategory::SOFTWARE)
    ->setImageUrl('https://example.com/productimage.jpg')
    ->setHomeUrl('https://example.com');

// ['id' => 'PROD-XY...', 'name' => 'My new product', ...]
$response = $service->createProduct($product)->parseJson();
```

### Update a product

To update a product use the `updateProduct` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Requests\UpdateProductRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$product = new UpdateProductRequest('PROD-XY458712546854478');
$product->setDescription('product description')
    ->setCategory(ProductCategory::ACADEMIC_SOFTWARE)
    ->setImageUrl('https://example.com/productimage.jpg')
    ->setHomeUrl('https://example.com');

$response = $service->updateProduct($product)->getStatusCode();  // 204
```

### You can also create a token for external use

To create a token use the `getToken` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getToken(); // array
```
