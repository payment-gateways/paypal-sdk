<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\PaymentMethod;
use PHPUnit\Framework\TestCase;

class PaymentMethodTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithNotData()
    {
        $paymentMethod = new PaymentMethod();

        $this->assertSame([], $paymentMethod->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPayerSelected()
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setPayerSelected('PAYPAL');

        $this->assertSame(['payer_selected' => 'PAYPAL'], $paymentMethod->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPayeePreferred()
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setPayeePreferred('IMMEDIATE_PAYMENT_REQUIRED');

        $this->assertSame(['payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'], $paymentMethod->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithStandardEntryClassCode()
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setStandardEntryClassCode('WEB');

        $this->assertSame(['standard_entry_class_code' => 'WEB'], $paymentMethod->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAllData()
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setPayerSelected('PAYPAL');
        $paymentMethod->setPayeePreferred('IMMEDIATE_PAYMENT_REQUIRED');
        $paymentMethod->setStandardEntryClassCode('WEB');

        $this->assertSame([
            'payer_selected' => 'PAYPAL',
            'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
            'standard_entry_class_code' => 'WEB'
        ], $paymentMethod->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setPayerSelected('PAYPAL');
        $paymentMethod->setPayeePreferred('IMMEDIATE_PAYMENT_REQUIRED');
        $paymentMethod->setStandardEntryClassCode('WEB');

        $this->assertSame('PAYPAL', $paymentMethod->getPayerSelected());
        $this->assertSame('IMMEDIATE_PAYMENT_REQUIRED', $paymentMethod->getPayeePreferred());
        $this->assertSame('WEB', $paymentMethod->getStandardEntryClassCode());

        $paymentMethod->setPayerSelected('MASTERCARD');
        $paymentMethod->setPayeePreferred('UNRESTRICTED');
        $paymentMethod->setStandardEntryClassCode('TEL');

        $this->assertSame('MASTERCARD', $paymentMethod->getPayerSelected());
        $this->assertSame('UNRESTRICTED', $paymentMethod->getPayeePreferred());
        $this->assertSame('TEL', $paymentMethod->getStandardEntryClassCode());
    }
}
