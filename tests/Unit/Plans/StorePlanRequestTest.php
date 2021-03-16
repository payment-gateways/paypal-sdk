<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Plans;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Plans\Constants\PlanStatus;
use PaymentGateway\PayPalSdk\Plans\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Tests\TestCase;
use PaymentGateway\PayPalSdk\Tests\Unit\Plans\Concerns\HasBillingCycles;

class StorePlanRequestTest extends TestCase
{
    use HasBillingCycles;

    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $billingCycleSet = $this->createBillingCycleSet();
        $request = new StorePlanRequest('P-3GM32410SK6114311MAU3BLY', 'Plan Name', $billingCycleSet);

        $this->assertSame([
            'product_id' => 'P-3GM32410SK6114311MAU3BLY',
            'name' => 'Plan Name',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => \PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH,
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
        $billingCycleSet = $this->createBillingCycleSet();

        $request = new StorePlanRequest('P-3GM32410SK6114311MAU3BLY', 'Plan Name', $billingCycleSet);
        $request->setPlanDescription('Plan description');
        $request->setPlanStatus('CREATED');

        $this->assertSame([
            'product_id' => 'P-3GM32410SK6114311MAU3BLY',
            'name' => 'Plan Name',
            'description' => 'Plan description',
            'status' => 'CREATED',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => \PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH,
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
        $json = $request->toArray();

        $this->assertSame($id, $request->getProductId());
        $this->assertSame($name, $request->getPlanName());
        $this->assertSame($description, $request->getPlanDescription());
        $this->assertSame($status, $request->getPlanStatus());

        $this->assertSame([
            'product_id' => $id,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => \PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH,
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
        ], $json);
    }
}
