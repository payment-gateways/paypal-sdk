<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Plans;

use PaymentGateway\PayPalSdk\Plans\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Tests\TestCase;
use PaymentGateway\PayPalSdk\Tests\Unit\Plans\Concerns\HasPaymentPreferences;

class UpdatePlanRequestTest extends TestCase
{
    use HasPaymentPreferences;

    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $request = new UpdatePlanRequest('P-3GM32410SK6114311MAU3BLY');

        $this->assertSame([], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithProductData()
    {
        $description = 'description';
        $paymentPreferences = $this->createPaymentPreferences();

        $request = new UpdatePlanRequest('P-3GM32410SK6114311MAU3BLY');
        $request->setPlanDescription($description);
        $request->setPaymentPreferences($paymentPreferences);

        $this->assertSame(
            [
                [
                    'op' => 'replace',
                    'path' => '/description',
                    'value' => $description
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/auto_bill_outstanding',
                    'value' => $paymentPreferences->isAutoBillOutstanding()
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/payment_failure_threshold',
                    'value' => $paymentPreferences->getPaymentFailureThreshold()
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/setup_fee_failure_action',
                    'value' => $paymentPreferences->getSetupFeeFailureAction()
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/setup_fee',
                    'value' => $paymentPreferences->getSetupFee()->toArray()
                ],
            ],
            $request->toArray()
        );
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $id = $this->faker->uuid;
        $description = $this->faker->paragraph;

        $request = new UpdatePlanRequest('P-3GM32410SK6114311MAU3BLY');
        $request->setPlanId($id);
        $request->setPlanDescription($description);
        $paymentPreferences = $this->createPaymentPreferences();
        $request->setPaymentPreferences($paymentPreferences);

        $this->assertSame($id, $request->getPlanId());
        $this->assertSame($description, $request->getPlanDescription());

        $this->assertSame(
            [
                [
                    'op' => 'replace',
                    'path' => '/description',
                    'value' => $description
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/auto_bill_outstanding',
                    'value' => $paymentPreferences->isAutoBillOutstanding()
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/payment_failure_threshold',
                    'value' => $paymentPreferences->getPaymentFailureThreshold()
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/setup_fee_failure_action',
                    'value' => $paymentPreferences->getSetupFeeFailureAction()
                ],
                [
                    'op' => 'replace',
                    'path' => '/payment_preferences/setup_fee',
                    'value' => $paymentPreferences->getSetupFee()->toArray()
                ],
            ],
            $request->toArray()
        );
    }
}
