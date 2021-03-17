<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\PhoneType;
use PaymentGateway\PayPalSdk\Subscriptions\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithMinimumData()
    {
        $phone = new Phone('573155047896');

        $this->assertSame([
            'phone_number' => '573155047896'
        ], $phone->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPhoneType()
    {
        $phone = new Phone('573155047896');
        $phone->setPhoneType(PhoneType::MOBILE);

        $this->assertSame([
            'phone_number' => '573155047896',
            'phone_type' => PhoneType::MOBILE
        ], $phone->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $phone = new Phone('573155047896');
        $phone->setPhoneType(PhoneType::MOBILE);

        $this->assertSame('573155047896', $phone->getPhoneNumber());
        $this->assertSame(PhoneType::MOBILE, $phone->getPhoneType());

        $phone->setPhoneNumber('572224444');
        $phone->setPhoneType(PhoneType::HOME);

        $this->assertSame('572224444', $phone->getPhoneNumber());
        $this->assertSame(PhoneType::HOME, $phone->getPhoneType());
    }
}
