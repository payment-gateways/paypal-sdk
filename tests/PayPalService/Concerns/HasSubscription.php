<?php

namespace PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns;

use PaymentGateway\PayPalApiMock\PayPalApiMock;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;

trait HasSubscription
{
    protected function createStoreSubscriptionRequest(): StoreSubscriptionRequest
    {
        return new StoreSubscriptionRequest('P-18T532823A424032WL7NIVUA');
    }

    protected function fakeSubscription(PayPalService $service, callable $payPalApi = null): array
    {
        $payPalApi = $payPalApi ?? new PayPalApiMock();
        $service->withHandler($payPalApi);

        return $service->createSubscription($this->createStoreSubscriptionRequest())->toArray();
    }
}
