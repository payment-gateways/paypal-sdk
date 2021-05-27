<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use DateTime;
use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
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

        $this->assertSame('P-18T532823A424032WL7NIVUA', $request->getPlanId());
        $this->assertSame(['plan_id' => 'P-18T532823A424032WL7NIVUA'], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithShippingAmount()
    {
        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');

        $shippingAmount = new Money(CurrencyCode::UNITED_STATES_DOLLAR, 400);
        $request->setShippingAmount($shippingAmount);

        $this->assertSame($shippingAmount, $request->getShippingAmount());
        $this->assertSame(
            [
                'plan_id' => 'P-18T532823A424032WL7NIVUA',
                'shipping_amount' => $shippingAmount->toArray()
            ],
            $request->toArray()
        );
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

        $this->assertSame($subscriber, $request->getSubscriber());
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
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;

        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);
        $request->setApplicationContext($applicationContext);

        $this->assertSame($applicationContext, $request->getApplicationContext());
        $this->assertSame(
            [
                'plan_id' => 'P-18T532823A424032WL7NIVUA',
                'application_context' => $applicationContext->toArray()
            ],
            $request->toArray()
        );
    }

    /**
     * @test
     */
    public function itCanChangeOtherRequestProperties()
    {
        $datetime = new DateTime('2010-12-30 23:21:46');
        $startTime = $datetime->format(DateTime::ATOM);
        $planId = 'P-99T999999A999999WL9ZZZZZ';
        $quantity = '10';
        $customId = 'XX-001';

        $request = new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
        $request->setPlanId($planId);
        $request->setStartTime($startTime);
        $request->setQuantity($quantity);
        $request->setCustomId($customId);

        $this->assertSame($planId, $request->getPlanId());
        $this->assertSame($startTime, $request->getStartTime());
        $this->assertSame($quantity, $request->getQuantity());
        $this->assertSame($customId, $request->getCustomId());
        $this->assertSame(
            [
                'plan_id' => $planId,
                'start_time' => $startTime,
                'quantity' => $quantity,
                'custom_id' => $customId
            ],
            $request->toArray()
        );
    }
}
