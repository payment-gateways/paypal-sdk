<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CountryCode;
use PaymentGateway\PayPalSdk\Subscriptions\ShippingAddress;
use PaymentGateway\PayPalSdk\Subscriptions\ShippingDetailAddressPortable;
use PaymentGateway\PayPalSdk\Subscriptions\ShippingDetailName;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithNoData()
    {
        $shippingAddress = new ShippingAddress();

        $this->assertSame([], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayArrayWithName()
    {
        $shippingAddress = new ShippingAddress();
        $shippingName = new ShippingDetailName($this->faker->name);
        $shippingAddress->setName($shippingName);

        $this->assertSame(['name' => $shippingName->toArray()], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayArrayWithAddress()
    {
        $shippingAddress = new ShippingAddress();
        $shippingDetailAddressPortable = new ShippingDetailAddressPortable(CountryCode::ARGENTINA);
        $shippingAddress->setAddress($shippingDetailAddressPortable);

        $this->assertSame(['address' => $shippingDetailAddressPortable->toArray()], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $shippingAddress = new ShippingAddress();
        $shippingName = new ShippingDetailName($this->faker->name);
        $shippingAddress->setName($shippingName);
        $shippingDetailAddressPortable = new ShippingDetailAddressPortable(CountryCode::ARGENTINA);
        $shippingAddress->setAddress($shippingDetailAddressPortable);

        $this->assertSame($shippingName, $shippingAddress->getName());
        $this->assertSame($shippingDetailAddressPortable, $shippingAddress->getAddress());
    }
}
