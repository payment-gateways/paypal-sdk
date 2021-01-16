<p align="center"><img src="https://blog.pleets.org/img/articles/paypal-sdk.png" height="150"></p>

<p align="center">
<a href="https://travis-ci.com/payment-gateways/paypal-sdk"><img src="https://travis-ci.com/payment-gateways/paypal-sdk.svg?branch=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/payment-gateways/paypal-sdk"><img src="https://img.shields.io/scrutinizer/g/payment-gateways/paypal-sdk.svg" alt="Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/payment-gateways/paypal-sdk/?branch=master"><img src="https://scrutinizer-ci.com/g/payment-gateways/paypal-sdk/badges/coverage.png?b=master" alt="Code Coverage"></a>
</p>

# PayPal SDK

This is an SDK for [PayPal REST APIS](https://developer.paypal.com/docs/api/overview/). The following APIs are currently supported.

- [Catalog Products API v1](https://developer.paypal.com/docs/api/catalog-products/v1)
- [Subscriptions API v1](https://developer.paypal.com/docs/api/subscriptions/v1)

<a href="https://sonarcloud.io/dashboard?id=payment-gateways_paypal-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=payment-gateways_paypal-sdk&metric=security_rating" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=payment-gateways_paypal-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=payment-gateways_paypal-sdk&metric=bugs" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=payment-gateways_paypal-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=payment-gateways_paypal-sdk&metric=code_smells" alt="Bugs"></a>

# Installation

Use following command to install this library:

```bash
composer require payment-gateways/paypal-sdk
```

# Usage

## Authentication

Go to [PayPal Developer site](https://developer.paypal.com/developer/applications) and get the **Client ID** and **Secret** for your app.
These credentials can be used in the service authentication as follows:

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
```

Thus, you can test the service authentication using the `getToken` method.

```php
$response = $service->getToken(); // array
```

You don't need to execute the `getToken` method for using the PayPal APIs. This function is only for testing purposes.

## Catalog products API

Merchants can use the Catalog Products API to create products, which are goods and services.

### List products

To get all products use the `getProducts` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getProducts()->toArray();
```

### Get a product

To get a single products use the `getProduct` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getProduct('PROD-8R6565867F172242R')->toArray();
```

### Create a product

To create a product use the `createProduct` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Products\Constants\ProductType;
use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$productRequest = new StoreProductRequest('My new product', ProductType::SERVICE);
$productRequest->setDescription('product description')
    ->setCategory(ProductCategory::SOFTWARE)
    ->setImageUrl('https://example.com/productimage.jpg')
    ->setHomeUrl('https://example.com');

// ['id' => 'PROD-XY...', 'name' => 'My new product', ...]
$response = $service->createProduct($productRequest)->toArray();
```

### Update a product

To update a product use the `updateProduct` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Requests\UpdateProductRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$productRequest = new UpdateProductRequest('PROD-XY458712546854478');
$productRequest->setDescription('product description')
    ->setCategory(ProductCategory::ACADEMIC_SOFTWARE)
    ->setImageUrl('https://example.com/productimage.jpg')
    ->setHomeUrl('https://example.com');

$service->updateProduct($productRequest);
```

## Subscriptions API

You can use billing plans and subscriptions to create subscriptions that process recurring PayPal payments for physical or digital goods, or services.

### List plans

To get all plans use the `getPlans` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getPlans()->toArray();
```

### Get a plan

To get a single plan use the `getPlan` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');
$response = $service->getPlan('P-18T532823A424032WL7NIVUA')->toArray();
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
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StorePlanRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$frequency = new Frequency(\PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH, 1);
$pricingSchema = new PricingSchema(new Money(CurrencyCode::UNITED_STATES_DOLLAR, '350'));
$billingCycle = new RegularBillingCycle($frequency, $pricingSchema);
$billingCycleSet = new BillingCycleSet();
$billingCycleSet->addBillingCycle($billingCycle);
$planRequest = new StorePlanRequest('PROD-8R6565867F172242R', 'New Plan', $billingCycleSet);

// ['id' => 'P-XY...', 'product_id' => 'PROD-8R6565867F172242R', 'name' => 'My Plan', ...]
$response = $service->createPlan($planRequest)->toArray();
```

### Update a plan

To update a product use the `updatePlan` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$paymentPreferences = new PaymentPreferences();
$paymentPreferences->setSetupFee(new Money(CurrencyCode::UNITED_STATES_DOLLAR, '250'));
$planRequest = new UpdatePlanRequest('P-18T532823A424032WL7NIVUA');
$planRequest->setPaymentPreferences($paymentPreferences);

$service->updatePlan($planRequest);
```

### Create a subscription

To create a subscription use the `createSubscription` method.

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->setAuth('AeA1QIZXiflr1', 'ECYYrrSHdKfk');

$subscriptionRequest = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');

// ["status": "APPROVAL_PENDING", "id": "I-GFCGPH9100S7", ...]
$response = $service->createSubscription($subscriptionRequest);
```

## Error Handling

In general, You can use the `toArray` method in all responses to get the service response data (except for patch operations),
otherwise you'll get an array with errors if something fails. You can check for a successful response using the `isSuccessful` method.
. 

```php
$response = $service->getProducts();

if (!$response->isSuccessful()) {
    var_dump($response->toArray());     // check the errors
} else {
    // array with data
    $response->toArray();
}
```

## Mocking

You can create your own PayPal API Mock for use with `PayPalService` like this

```php
use PaymentGateway\PayPalSdk\PayPalService;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->withHandler($handler);
```

The handler must be a `callable` type. If you prefer, you can use the [PayPal API Mock](https://github.com/payment-gateways/paypal-api-mock)
adding the following to your project

```bash
composer require --dev payment-gateways/paypal-api-mock
```

After, you could use the class `PayPalApiMock` as a handler

```php
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalApiMock\PayPalApiMock;

$service = new PayPalService('https://api.sandbox.paypal.com');
$service->withHandler(new PayPalApiMock());
```