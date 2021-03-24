<?php

namespace PaymentGateway\PayPalSdk\Tests\Api;

use EasyHttp\MockBuilder\HttpMock;
use PaymentGateway\PayPalSdk\Api\SubscriptionsApi;
use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\PayerName;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Subscriber;
use PaymentGateway\PayPalSdk\Tests\Api\Concerns\HasMockBuilder;
use PHPUnit\Framework\TestCase;

class SubscriptionsApiTest extends TestCase
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
    public function itCanGetASubscription()
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v1\/billing\/subscriptions\/(I-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(200)
                ->json([
                    'status' => 'APPROVAL_PENDING',
                    'id' => 'I-7L1WCE5UKJN9',
                ]);

        $service = new SubscriptionsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getSubscription('I-7L1WCE5UKJN9');
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $json);
        $this->assertArrayHasKey('id', $json);
    }

    /**
     * @test
     */
    public function itCanCreateASubscriptionWithTheMinimumData()
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v1/billing/subscriptions')
            ->then()
                ->statusCode(201)
                ->json([
                    'status' => 'APPROVAL_PENDING',
                    'id' => 'I-7L1WCE5UKJN9',
                ]);

        $service = new SubscriptionsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $subscriptionRequest = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $response = $service->createSubscription($subscriptionRequest);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertSame('APPROVAL_PENDING', $json['status']);
        $this->assertSame('I-7L1WCE5UKJN9', $json['id']);
    }

    /**
     * @test
     */
    public function itCanCreateASubscriptionWithSubscriberInfo()
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v1/billing/subscriptions')
            ->then()
                ->statusCode(201)
                ->json([
                    'status' => 'APPROVAL_PENDING',
                    'id' => 'I-7L1WCE5UKJN9',
                ]);

        $service = new SubscriptionsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

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
    }

    /**
     * @test
     */
    public function itCanCreateASubscriptionWithApplicationContext()
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v1/billing/subscriptions')
            ->then()
                ->statusCode(201)
                ->json([
                    'status' => 'APPROVAL_PENDING',
                    'id' => 'I-7L1WCE5UKJN9',
                ]);

        $service = new SubscriptionsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $subscriptionRequest = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $applicationContext = new ApplicationContext('http://example.com/return-url', 'http://example.com/cancel-url');
        $subscriptionRequest->setApplicationContext($applicationContext);
        $response = $service->createSubscription($subscriptionRequest);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $json);
        $this->assertArrayHasKey('id', $json);
    }

    /**
     * @test
     */
    public function itDetectsNotSuccessfulResponses()
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v1\/billing\/subscriptions\/(I-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(500)
                ->body('Server Error');

        $service = new SubscriptionsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getSubscription('I-7L1WCE5UKJN9');

        $this->assertFalse($response->isSuccessful());
        $this->assertSame([], $response->toArray());
    }
}
