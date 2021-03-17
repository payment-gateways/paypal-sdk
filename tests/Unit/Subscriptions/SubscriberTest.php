<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\PayerName;
use PaymentGateway\PayPalSdk\Subscriptions\Phone;
use PaymentGateway\PayPalSdk\Subscriptions\ShippingAddress;
use PaymentGateway\PayPalSdk\Subscriptions\ShippingDetailName;
use PaymentGateway\PayPalSdk\Subscriptions\Subscriber;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class SubscriberTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithMinimumData()
    {
        $subscriber = new Subscriber();

        $this->assertSame([], $subscriber->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPayerNameData()
    {
        $subscriber = new Subscriber();
        $name = new PayerName();
        $name->setGivenName('John Doe');
        $subscriber->setName($name);

        $this->assertSame(['name' => $name->toArray()], $subscriber->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithEmailAddressData()
    {
        $subscriber = new Subscriber();
        $subscriber->setEmailAddress('john.doe@gmail.com');

        $this->assertSame(['email_address' => 'john.doe@gmail.com'], $subscriber->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPayerIdData()
    {
        $subscriber = new Subscriber();
        $subscriber->setPayerId('ID-581251');

        $this->assertSame(['payer_id' => 'ID-581251'], $subscriber->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPhoneData()
    {
        $subscriber = new Subscriber();
        $phone = new Phone($this->faker->phoneNumber);
        $subscriber->setPhone($phone);

        $this->assertSame(['phone' => $phone->toArray()], $subscriber->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithShippingAddressData()
    {
        $subscriber = new Subscriber();
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setName(new ShippingDetailName('Steve Jobs'));
        $subscriber->setShippingAddress($shippingAddress);

        $this->assertSame(['shipping_address' => $shippingAddress->toArray()], $subscriber->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $subscriber = new Subscriber();
        $name = new PayerName();
        $name->setGivenName($this->faker->name);
        $subscriber->setName($name);
        $email = $this->faker->email;
        $subscriber->setEmailAddress($email);
        $payerId = $this->faker->uuid;
        $subscriber->setPayerId($payerId);
        $phone = new Phone($this->faker->phoneNumber);
        $subscriber->setPhone($phone);
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setName(new ShippingDetailName($this->faker->name));
        $subscriber->setShippingAddress($shippingAddress);

        $this->assertSame($name, $subscriber->getName());
        $this->assertSame($email, $subscriber->getEmailAddress());
        $this->assertSame($payerId, $subscriber->getPayerId());
        $this->assertSame($phone, $subscriber->getPhone());
        $this->assertSame($shippingAddress, $subscriber->getShippingAddress());
    }
}
