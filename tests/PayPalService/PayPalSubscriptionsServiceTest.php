<?php

namespace PaymentGateway\PayPalSdk\Tests\PayPalService;

use PaymentGateway\PayPalApiMock\PayPalApiMock;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\RegularBillingCycle;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PayerName;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Subscriber;
use PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns\HasPlan;
use PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns\HasProduct;
use PHPUnit\Framework\TestCase;

class PayPalSubscriptionsServiceTest extends TestCase
{
    use HasProduct;
    use HasPlan;

    protected string $username = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
    protected string $password = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';
    protected string $baseUri = 'https://api.sandbox.paypal.com';

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
        $planId = $response->toArray()['id'];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
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
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
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
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
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
        $paymentPreferences = new PaymentPreferences();
        $paymentPreferences->setSetupFee(new Money(CurrencyCode::UNITED_STATES_DOLLAR, $value));
        $planRequest = new UpdatePlanRequest($plan['id']);
        $planRequest->setPaymentPreferences($paymentPreferences);

        $response = $service->updatePlan($planRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
        $this->assertSame(
            "$value",
            $payPalApi->getPlan($plan['id'])['payment_preferences']['setup_fee']['value']
        );
    }

    /**
     * @test
     */
    public function itCanUpdateAPlanWithTheMinimumData()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);
        $plan = $this->fakePlan($service, $product['id'], $payPalApi);

        $paymentPreferences = new PaymentPreferences();
        $planRequest = new UpdatePlanRequest($plan['id']);
        $planRequest->setPaymentPreferences($paymentPreferences);

        $response = $service->updatePlan($planRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function itCanCreateASubscriptionWithTheMinimumData()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $service->withHandler(new PayPalApiMock());

        $subscriptionRequest = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $response = $service->createSubscription($subscriptionRequest);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $json);
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('create_time', $json);
        $this->assertArrayHasKey('links', $json);
    }

    /**
     * @test
     */
    public function itCanCreateASubscriptionWithSubscriberInfo()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $service->withHandler(new PayPalApiMock());

        $subscriptionRequest = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $subscriber = new Subscriber();
        $name = new PayerName();
        $name->setGivenName('John Doe');
        $subscriber->setName($name);
        $subscriptionRequest->setSubscriber($subscriber);
        $response = $service->createSubscription($subscriptionRequest);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $json);
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('create_time', $json);
        $this->assertArrayHasKey('links', $json);
    }

    /**
     * @test
     */
    public function itCanCreateASubscriptionWithApplicationContext()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $service->withHandler(new PayPalApiMock());

        $subscriptionRequest = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $applicationContext = new ApplicationContext('http://example.com/return-url', 'http://example.com/cancel-url');
        $subscriptionRequest->setApplicationContext($applicationContext);
        $response = $service->createSubscription($subscriptionRequest);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $json);
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('create_time', $json);
        $this->assertArrayHasKey('links', $json);
    }
}
