<?php

namespace PaymentGateway\PayPalSdk\Tests\Api;

use EasyHttp\MockBuilder\HttpMock;
use PaymentGateway\PayPalSdk\Api\BillingPlansApi;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\RegularBillingCycle;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Tests\Api\Concerns\HasMockBuilder;
use PHPUnit\Framework\TestCase;

class BillingPlansApiTest extends TestCase
{
    use HasMockBuilder;

    protected string $baseUri = 'https://api.sandbox.paypal.com';

    public function setUp(): void
    {
        $this->createBuilder();
        parent::setUp();
    }

    /**
     * @test
     */
    public function itCanGetAPlan()
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v1\/billing\/plans\/(P-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(200)
                ->json([
                    'id' => 'P-3BD24823245172349MBHGMCQ',
                    'product_id' => 'PROD-49A80826MF300605W',
                    'name' => 'Plan name',
                    'status' => 'ACTIVE',
                ]);

        $service = new BillingPlansApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getPlan('P-3BD24823245172349MBHGMCQ');
        $planId = $response->toArray()['id'];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame('P-3BD24823245172349MBHGMCQ', $planId);
    }


    /**
     * @test
     */
    public function itCanGetThePlanList()
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathIs('/v1/billing/plans')
            ->then()
                ->statusCode(200)
                ->json([
                    'plans' => [
                        [
                            'id' => 'P-3BD24823245172349MBHGMCQ',
                            'name' => 'Plan name',
                            'status' => 'ACTIVE',
                        ]
                    ],
                ]);

        $service = new BillingPlansApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getPlans();
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('plans', $json);
        $this->assertSame('P-3BD24823245172349MBHGMCQ', $json['plans'][0]['id']);
    }

    /**
     * @test
     */
    public function itCanCreateAPlan()
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v1/billing/plans')
            ->then()
                ->statusCode(201)
                ->json([
                    'id' => 'P-3BD24823245172349MBHGMCQ',
                    'product_id' => 'PROD-49A80826MF300605W',
                    'status' => 'ACTIVE',
                ]);

        $service = new BillingPlansApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $frequency = new Frequency(\PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH, 1);
        $pricingSchema = new PricingSchema(new Money(CurrencyCode::UNITED_STATES_DOLLAR, '350'));
        $billingCycle = new RegularBillingCycle($frequency, $pricingSchema);
        $billingCycleSet = new BillingCycleSet();
        $billingCycleSet->addBillingCycle($billingCycle);
        $plan = new StorePlanRequest('PROD-49A80826MF300605W', 'New Plan', $billingCycleSet);

        $response = $service->createPlan($plan);
        $planId = $response->toArray()['id'];

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertSame('P-3BD24823245172349MBHGMCQ', $planId);
    }

    /**
     * @test
     */
    public function itCanUpdateAPlan()
    {
        $this->builder
            ->when()
                ->methodIs('PATCH')
                ->pathMatch('/v1\/billing\/plans\/(P-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(204);

        $service = new BillingPlansApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $value = random_int(0, 100);
        $paymentPreferences = new PaymentPreferences();
        $paymentPreferences->setSetupFee(new Money(CurrencyCode::UNITED_STATES_DOLLAR, $value));
        $planRequest = new UpdatePlanRequest('P-3BD24823245172349MBHGMCQ');
        $planRequest->setPaymentPreferences($paymentPreferences);

        $response = $service->updatePlan($planRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function itCanUpdateAPlanWithTheMinimumData()
    {
        $this->builder
            ->when()
                ->methodIs('PATCH')
                ->pathMatch('/v1\/billing\/plans\/(P-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(204);

        $service = new BillingPlansApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $paymentPreferences = new PaymentPreferences();
        $planRequest = new UpdatePlanRequest('P-3BD24823245172349MBHGMCQ');
        $planRequest->setPaymentPreferences($paymentPreferences);

        $response = $service->updatePlan($planRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
    }
}
