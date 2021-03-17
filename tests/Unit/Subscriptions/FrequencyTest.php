<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\IntervalUnit;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PHPUnit\Framework\TestCase;

class FrequencyTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithAllData()
    {
        $frequency = new Frequency(IntervalUnit::MONTH, 2);

        $this->assertSame([
            'interval_unit' => IntervalUnit::MONTH,
            'interval_count' => 2
        ], $frequency->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $frequency = new Frequency(IntervalUnit::MONTH, 2);

        $this->assertSame(IntervalUnit::MONTH, $frequency->getFrequency());
        $this->assertSame(2, $frequency->getQuantity());

        $frequency->setFrequency(IntervalUnit::YEAR);
        $frequency->setQuantity(1);

        $this->assertSame(IntervalUnit::YEAR, $frequency->getFrequency());
        $this->assertSame(1, $frequency->getQuantity());
    }
}
