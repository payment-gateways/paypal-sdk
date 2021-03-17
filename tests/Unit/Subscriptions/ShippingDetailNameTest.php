<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\ShippingDetailName;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class ShippingDetailNameTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithAllData()
    {
        $shippingDetailName = new ShippingDetailName('John Doe');

        $this->assertSame(['full_name' => 'John Doe'], $shippingDetailName->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $name = $this->faker->name;
        $shippingDetailName = new ShippingDetailName($name);

        $this->assertSame($name, $shippingDetailName->getFullName());

        $name = $this->faker->name;
        $shippingDetailName->setFullName($name);

        $this->assertSame($name, $shippingDetailName->getFullName());
    }
}
