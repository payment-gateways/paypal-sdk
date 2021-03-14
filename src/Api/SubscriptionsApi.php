<?php

namespace PaymentGateway\PayPalSdk\Api;

use PaymentGateway\PayPalSdk\Contracts\PayPalResponse;
use PaymentGateway\PayPalSdk\PayPalApi;
use PaymentGateway\PayPalSdk\Responses\GetResponse;
use PaymentGateway\PayPalSdk\Responses\PostResponse;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StoreSubscriptionRequest;

class SubscriptionsApi extends PayPalApi
{
    public function getSubscription(string $id): PayPalResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/billing/subscriptions/' . $id);
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function createSubscription(StoreSubscriptionRequest $subscriptionRequest): PayPalResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v1/billing/subscriptions');
        $this->setAuthentication()->setJson($subscriptionRequest->toArray());

        return new PostResponse($this->client->execute());
    }
}
