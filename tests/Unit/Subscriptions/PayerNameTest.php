<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\PayerName;
use PHPUnit\Framework\TestCase;

class PayerNameTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithNotData()
    {
        $payerName = new PayerName();

        $this->assertSame([], $payerName->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithGivenName()
    {
        $payerName = new PayerName();
        $payerName->setGivenName('John');

        $this->assertSame(['given_name' => 'John'], $payerName->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithSurname()
    {
        $payerName = new PayerName();
        $payerName->setSurname('Doe');

        $this->assertSame(['surname' => 'Doe'], $payerName->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAllData()
    {
        $payerName = new PayerName();
        $payerName->setGivenName('John');
        $payerName->setSurname('Doe');

        $this->assertSame([
            'given_name' => 'John',
            'surname' => 'Doe'
        ], $payerName->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $payerName = new PayerName();
        $payerName->setGivenName('John');
        $payerName->setSurname('Doe');

        $this->assertSame('John', $payerName->getGivenName());
        $this->assertSame('Doe', $payerName->getSurname());

        $payerName->setGivenName('Steve');
        $payerName->setSurname('Jobs');

        $this->assertSame('Steve', $payerName->getGivenName());
        $this->assertSame('Jobs', $payerName->getSurname());
    }
}
