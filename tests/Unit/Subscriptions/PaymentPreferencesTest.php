<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\InitialPaymentFailureAction;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;
use PHPUnit\Framework\TestCase;

class PaymentPreferencesTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithMinimumData()
    {
        $paymentPreferences = new PaymentPreferences();

        $this->assertSame([
            'auto_bill_outstanding' => true,
            'setup_fee_failure_action' => 'CANCEL',
            'payment_failure_threshold' => 0
        ], $paymentPreferences->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithSetupFee()
    {
        $paymentPreferences = new PaymentPreferences();
        $paymentPreferences->setSetupFee(new Money(CurrencyCode::AUSTRALIAN_DOLLAR, '12'));

        $this->assertSame([
            'auto_bill_outstanding' => true,
            'setup_fee_failure_action' => 'CANCEL',
            'payment_failure_threshold' => 0,
            'setup_fee' => [
                'currency_code' => 'AUD',
                'value' => '12'
            ]
        ], $paymentPreferences->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $paymentPreferences = new PaymentPreferences();
        $money = new Money(CurrencyCode::AUSTRALIAN_DOLLAR, '12');
        $paymentPreferences->setSetupFee($money);

        $this->assertTrue($paymentPreferences->isAutoBillOutstanding());
        $this->assertSame(0, $paymentPreferences->getPaymentFailureThreshold());
        $this->assertSame(InitialPaymentFailureAction::CANCEL, $paymentPreferences->getSetupFeeFailureAction());
        $this->assertSame($money, $paymentPreferences->getSetupFee());

        $paymentPreferences->setAutoBillOutstanding(false);
        $paymentPreferences->setPaymentFailureThreshold(1);
        $paymentPreferences->setSetupFeeFailureAction(InitialPaymentFailureAction::CONTINUE);

        $this->assertFalse($paymentPreferences->isAutoBillOutstanding());
        $this->assertSame(1, $paymentPreferences->getPaymentFailureThreshold());
        $this->assertSame(InitialPaymentFailureAction::CONTINUE, $paymentPreferences->getSetupFeeFailureAction());
    }
}
