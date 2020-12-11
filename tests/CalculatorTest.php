<?php

namespace PaymentGateway\PayPalSdk\Tests;

use PaymentGateway\PayPalSdk\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function itSums()
    {
        $calculator = new Calculator();
        $sum = $calculator->sum(7, 8);

        $this->assertSame(15, $sum);
    }
}