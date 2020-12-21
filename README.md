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

### Get a product

To get a single products use the `getProduct` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getProduct('PROD-8R6565867F172242R')->parseJson();
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

## Subscriptions API

You can use billing plans and subscriptions to create subscriptions that process recurring PayPal payments for physical or digital goods, or services.

### List plans

To get all plans use the `getPlans` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getPlans()->parseJson();
```

### Get a plan

To get a single plan use the `getPlan` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getPlan('P-18T532823A424032WL7NIVUA')->parseJson();
```

### Create a plan

To create a product use the `createPlan` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\RegularBillingCycle;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;
use PaymentGateway\PayPalSdk\Requests\StorePlanRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$frequency = new Frequency(\PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH, 1);
$pricingSchema = new PricingSchema(new Money(CurrencyCode::UNITED_STATES_DOLLAR, '350'));
$billingCycle = new RegularBillingCycle($frequency, $pricingSchema);
$billingCycleSet = new BillingCycleSet();
$billingCycleSet->addBillingCycle($billingCycle);
$plan = new StorePlanRequest('PROD-8R6565867F172242R', 'New Plan', $billingCycleSet);

// ['id' => 'P-XY...', 'product_id' => 'PROD-8R6565867F172242R', 'name' => 'My Plan', ...]
$response = $service->createPlan($plan)->parseJson();
```

### Update a plan

To update a product use the `updatePlan` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, '250');
$paymentPreferences = new PaymentPreferences($money);
$planRequest = new UpdatePlanRequest('P-18T532823A424032WL7NIVUA');
$planRequest->setPaymentPreferences($paymentPreferences);

$response = $service->updatePlan($planRequest)->getStatusCode();  // 204
```

## Utilities

### Token creation

You can also create a token for external use. To create a token use the `getToken` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getToken(); // array
```
