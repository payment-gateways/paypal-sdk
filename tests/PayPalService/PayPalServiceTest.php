<?php

namespace PaymentGateway\PayPalSdk\Tests\PayPalService;

use PaymentGateway\PayPalSdk\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Constants\ProductType;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Requests\UpdateProductRequest;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\RegularBillingCycle;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;
use PaymentGateway\PayPalSdk\Tests\Mocks\PayPalApi\PayPalApiMock;
use PaymentGateway\PayPalSdk\Tests\Mocks\Responses\PayPalApiResponse;
use PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns\HasPlan;
use PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns\HasProduct;
use PHPUnit\Framework\TestCase;

class PayPalServiceTest extends TestCase
{
    use HasProduct;
    use HasPlan;

    protected $username = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
    protected $password = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';
    protected $baseUri = 'https://api.sandbox.paypal.com';

    /**
     * @test
     */
    public function itCanGetTheAuthToken()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $service->withHandler(new PayPalApiMock());
        $response = $service->getToken();

        $this->assertArrayHasKey('scope', $response);
        $this->assertArrayHasKey('access_token', $response);
        $this->assertArrayHasKey('token_type', $response);
        $this->assertArrayHasKey('app_id', $response);
        $this->assertArrayHasKey('expires_in', $response);
        $this->assertArrayHasKey('nonce', $response);
    }

    /**
     * @test
     */
    public function itCanCreateAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);

        $product = new StoreProductRequest('My new product', ProductType::SERVICE);
        $product->setDescription('product description')
            ->setCategory(ProductCategory::SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $payPalApi = new PayPalApiMock();
        $service->withHandler($payPalApi);
        $response = $service->createProduct($product);
        $json = $response->parseJson();

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('My new product', $json['name']);
        $this->assertSame('product description', $json['description']);
        $this->assertSame(ProductCategory::SOFTWARE, $json['category']);
        $this->assertSame('https://example.com/productimage.jpg', $json['image_url']);
        $this->assertSame('https://example.com', $json['home_url']);
    }

    /**
     * @test
     */
    public function itCanGetTheProductList()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $product = $this->fakeProduct($service);

        $response = $service->getProducts();
        $json = $response->parseJson();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertArrayHasKey('products', $json);
        $this->assertSame($product['name'], $json['products'][0]['name']);
    }

    /**
     * @test
     */
    public function itCanGetAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);

        $response = $service->getProduct($product['id']);
        $json = $response->parseJson();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($product['id'], $json['id']);
        $this->assertSame($product['name'], $json['name']);
    }

    /**
     * @test
     */
    public function itCanUpdateAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);

        $productRequest = new UpdateProductRequest($product['id']);
        $productRequest->setDescription('product description')
            ->setCategory(ProductCategory::ACADEMIC_SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $response = $service->updateProduct($productRequest);

        $this->assertSame(204, $response->getStatusCode());
        $this->assertSame('product description', $payPalApi->getProduct($product['id'])['description']);
        $this->assertSame(ProductCategory::ACADEMIC_SOFTWARE, $payPalApi->getProduct($product['id'])['category']);
        $this->assertSame('https://example.com/productimage.jpg', $payPalApi->getProduct($product['id'])['image_url']);
        $this->assertSame('https://example.com', $payPalApi->getProduct($product['id'])['home_url']);
    }

    /**
     * @test
     */
    public function itCanCreateAPlan()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $prod = $this->fakeProduct($service, $payPalApi);

        $frequency = new Frequency(\PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH, 1);
        $pricingSchema = new PricingSchema(new Money(CurrencyCode::UNITED_STATES_DOLLAR, '350'));
        $billingCycle = new RegularBillingCycle($frequency, $pricingSchema);
        $billingCycleSet = new BillingCycleSet();
        $billingCycleSet->addBillingCycle($billingCycle);
        $plan = new StorePlanRequest($prod['id'], 'New Plan', $billingCycleSet);

        $response = $service->createPlan($plan);
        $planId = $response->parseJson()['id'];

        $this->assertSame(201, $response->getStatusCode());
        //$this->assertSame(PayPalApiResponse::planCreated($plan->toArray(), $planId), $response->parseJson());
    }

    /**
     * @test
     */
    public function itCanGetThePlanList()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);
        $plan = $this->fakePlan($service, $product['id'], $payPalApi);

        $response = $service->getPlans();
        $json = $response->parseJson();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertArrayHasKey('plans', $json);
        $this->assertSame($plan['name'], $json['plans'][0]['name']);
    }

    /**
     * @test
     */
    public function itCanGetAPlan()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);
        $plan = $this->fakePlan($service, $product['id'], $payPalApi);

        $response = $service->getPlan($plan['id']);
        $json = $response->parseJson();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($plan['name'], $json['name']);
        $this->assertSame($product['id'], $json['product_id']);
    }

    /**
     * @test
     */
    public function itCanUpdateAPlan()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);
        $plan = $this->fakePlan($service, $product['id'], $payPalApi);

        $value = random_int(0, 100);
        $money = new Money(CurrencyCode::UNITED_STATES_DOLLAR, $value);
        $paymentPreferences = new PaymentPreferences($money);
        $planRequest = new UpdatePlanRequest($plan['id']);
        $planRequest->setPaymentPreferences($paymentPreferences);

        $response = $service->updatePlan($planRequest);

        $this->assertSame(204, $response->getStatusCode());
        $this->assertSame(
            "$value",
            $payPalApi->getPlan($plan['id'])['payment_preferences']['setup_fee']['value']
        );
    }
}
