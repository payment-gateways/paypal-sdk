<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Plans;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Plans\Constants\PlanStatus;
use PaymentGateway\PayPalSdk\Plans\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\IntervalUnit;
use PaymentGateway\PayPalSdk\Tests\TestCase;
use PaymentGateway\PayPalSdk\Tests\Unit\Plans\Concerns\HasBillingCycles;
use PaymentGateway\PayPalSdk\Tests\Unit\Plans\Concerns\HasPaymentPreferences;

class StorePlanRequestTest extends TestCase
{
    use HasBillingCycles;
    use HasPaymentPreferences;

    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $productId = $this->faker->uuid;
        $planName = $this->faker->name;

        $billingCycleSet = $this->createBillingCycleSet();
        $request = new StorePlanRequest($productId, $planName, $billingCycleSet);

        $this->assertSame([
            'product_id' => $productId,
            'name' => $planName,
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => IntervalUnit::MONTH,
                        'interval_count' => $billingCycleSet->getBillingCycles()[0]->getFrequency()->getQuantity()
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 1,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'currency_code' => CurrencyCode::UNITED_STATES_DOLLAR,
                            'value' => $billingCycleSet->getBillingCycles()[0]
                                ->getPricingSchema()->getFixedPrince()->getValue()
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee_failure_action' => 'CANCEL',
                'payment_failure_threshold' => 0,
                'setup_fee' => [
                    'currency_code' => 'USD',
                    'value' => '0'
                ]
            ]
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithPlanData()
    {
        $productId = $this->faker->uuid;
        $planName = $this->faker->name;
        $description = $this->faker->paragraph;

        $billingCycleSet = $this->createBillingCycleSet();

        $request = new StorePlanRequest($productId, $planName, $billingCycleSet);
        $request->setPlanDescription($description);
        $request->setPlanStatus('CREATED');

        $this->assertSame([
            'product_id' => $productId,
            'name' => $planName,
            'description' => $description,
            'status' => 'CREATED',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => IntervalUnit::MONTH,
                        'interval_count' => $billingCycleSet->getBillingCycles()[0]->getFrequency()->getQuantity()
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 1,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'currency_code' => CurrencyCode::UNITED_STATES_DOLLAR,
                            'value' => $billingCycleSet->getBillingCycles()[0]
                                ->getPricingSchema()->getFixedPrince()->getValue()
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee_failure_action' => 'CANCEL',
                'payment_failure_threshold' => 0,
                'setup_fee' => [
                    'currency_code' => 'USD',
                    'value' => '0'
                ]
            ]
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $id = $this->faker->uuid;
        $name = $this->faker->name;
        $status = PlanStatus::CREATED;
        $description = $this->faker->paragraph;

        $request = new StorePlanRequest('P-3GM32410SK6114311MAU3BLY', 'Plan Name', $this->createBillingCycleSet());
        $request->setProductId($id);
        $request->setPlanName($name);
        $request->setPlanDescription($description);
        $request->setPlanStatus($status);
        $billingCycleSet = $this->createBillingCycleSet();
        $request->setBillingCycleSet($billingCycleSet);
        $paymentPreferences = $this->createPaymentPreferences();
        $request->setPaymentPreferences($paymentPreferences);
        $json = $request->toArray();

        $this->assertSame($id, $request->getProductId());
        $this->assertSame($name, $request->getPlanName());
        $this->assertSame($description, $request->getPlanDescription());
        $this->assertSame($status, $request->getPlanStatus());
        $this->assertSame($billingCycleSet, $request->getBillingCycleSet());
        $this->assertSame($paymentPreferences, $request->getPaymentPreferences());

        $this->assertSame([
            'product_id' => $id,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => IntervalUnit::MONTH,
                        'interval_count' => $billingCycleSet->getBillingCycles()[0]->getFrequency()->getQuantity()
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 1,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'currency_code' => CurrencyCode::UNITED_STATES_DOLLAR,
                            'value' => $billingCycleSet->getBillingCycles()[0]
                                ->getPricingSchema()->getFixedPrince()->getValue()
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee_failure_action' => 'CANCEL',
                'payment_failure_threshold' => 0,
                'setup_fee' => [
                    'currency_code' => 'USD',
                    'value' => $paymentPreferences->getSetupFee()->getValue()
                ]
            ]
        ], $json);
    }
}
