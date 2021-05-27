<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\PayerName;
use PaymentGateway\PayPalSdk\Subscriptions\Phone;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Subscriber;
use PaymentGateway\PayPalSdk\Tests\TestCase;

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
        $subscriberFirstName = $this->faker->firstName;
        $subscriberLastName = $this->faker->lastName;
        $emailAddress = $this->faker->address;
        $payerId = $this->faker->uuid;

        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $subscriber = new Subscriber();
        $name = new PayerName();
        $name->setGivenName($subscriberFirstName);
        $name->setSurname($subscriberLastName);
        $subscriber->setName($name);
        $subscriber->setEmailAddress($emailAddress);
        $subscriber->setPayerId($payerId);
        $subscriber->setPhone(new Phone($this->faker->phoneNumber));
        $request->setSubscriber($subscriber);

        $this->assertSame(
            [
                'plan_id' => 'P-18T532823A424032WL7NIVUA',
                'subscriber' => $subscriber->toArray()
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
