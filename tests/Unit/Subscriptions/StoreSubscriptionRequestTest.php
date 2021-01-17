<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\PayerName;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Subscriber;
use PHPUnit\Framework\TestCase;

class StoreSubscriptionRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');

        $this->assertSame(['plan_id' => 'P-18T532823A424032WL7NIVUA'], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithSubscriberData()
    {
        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $subscriber = new Subscriber();
        $name = new PayerName();
        $name->setGivenName('John Doe');
        $subscriber->setName($name);
        $request->setSubscriber($subscriber);

        $this->assertSame(
            [
            'plan_id' => 'P-18T532823A424032WL7NIVUA',
            'subscriber' => [
                'name' => [
                    'given_name' => 'John Doe'
                ]
            ]
            ],
            $request->toArray()
        );
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithApplicationContextData()
    {
        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $applicationContext = new ApplicationContext('http://example.com/return-url', 'http://example.com/cancel-url');
        $request->setApplicationContext($applicationContext);

        $this->assertSame(
            [
            'plan_id' => 'P-18T532823A424032WL7NIVUA',
            'application_context' => [
                'return_url' => 'http://example.com/return-url',
                'cancel_url' => 'http://example.com/cancel-url',
            ]
            ],
            $request->toArray()
        );
    }
}
