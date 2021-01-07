<?php

namespace PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns;

use PaymentGateway\PayPalApiMock\PayPalApiMock;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\BillingCycleSet;
use PaymentGateway\PayPalSdk\Subscriptions\BillingCycles\RegularBillingCycle;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\CurrencyCode;
use PaymentGateway\PayPalSdk\Subscriptions\Frequency;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\PricingSchema;

trait HasPlan
{
    protected function createStorePlanRequest(string $productId): StorePlanRequest
    {
        $frequency = new Frequency(\PaymentGateway\PayPalSdk\Subscriptions\Constants\Frequency::MONTH, 1);
        $pricingSchema = new PricingSchema(new Money(CurrencyCode::UNITED_STATES_DOLLAR, '350'));
        $billingCycle = new RegularBillingCycle($frequency, $pricingSchema);
        $billingCycleSet = new BillingCycleSet();
        $billingCycleSet->addBillingCycle($billingCycle);

        return new StorePlanRequest($productId, 'New Plan', $billingCycleSet);
    }

    protected function fakePlan(PayPalService $service, string $productId, callable $payPalApi = null): array
    {
        $payPalApi = $payPalApi ?? new PayPalApiMock();
        $service->withHandler($payPalApi);

        return $service->createPlan($this->createStorePlanRequest($productId))->toArray();
    }
}
