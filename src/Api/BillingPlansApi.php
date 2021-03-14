<?php

namespace PaymentGateway\PayPalSdk\Api;

use PaymentGateway\PayPalSdk\Contracts\PayPalResponse;
use PaymentGateway\PayPalSdk\PayPalApi;
use PaymentGateway\PayPalSdk\Responses\GetResponse;
use PaymentGateway\PayPalSdk\Responses\PatchResponse;
use PaymentGateway\PayPalSdk\Responses\PostResponse;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\UpdatePlanRequest;

class BillingPlansApi extends PayPalApi
{
    public function getPlan(string $id): PayPalResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/billing/plans/' . $id);
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function getPlans(): PayPalResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/billing/plans');
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function createPlan(StorePlanRequest $storePlanRequest): PayPalResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v1/billing/plans');
        $this->setAuthentication()->setJson($storePlanRequest->toArray());

        return new PostResponse($this->client->execute());
    }

    public function updatePlan(UpdatePlanRequest $planRequest): PayPalResponse
    {
        $this->client->prepareRequest('PATCH', $this->baseUri . '/v1/billing/plans/' . $planRequest->getId());
        $this->setAuthentication()->setJson($planRequest->toArray());

        return new PatchResponse($this->client->execute());
    }
}
