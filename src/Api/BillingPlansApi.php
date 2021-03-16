<?php

namespace PaymentGateway\PayPalSdk\Api;

use PaymentGateway\PayPalSdk\Contracts\PayPalResponse;
use PaymentGateway\PayPalSdk\PayPalApi;
use PaymentGateway\PayPalSdk\Responses\GetResponse;
use PaymentGateway\PayPalSdk\Responses\PatchResponse;
use PaymentGateway\PayPalSdk\Responses\PostResponse;
use PaymentGateway\PayPalSdk\Plans\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Plans\Requests\UpdatePlanRequest;

/**
 * Billing Plans API
 *
 * This API is not the deprecated API /v1/payments/billing-plans.
 * This implementation use the /v1/billing/plans endpoints instead.
 *
 * @see https://developer.paypal.com/docs/api/payments.billing-plans/v1/ (deprecated)
 * @see https://developer.paypal.com/docs/api/subscriptions/v1/ (new API)
 */
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
        $this->client->prepareRequest('PATCH', $this->baseUri . '/v1/billing/plans/' . $planRequest->getPlanId());
        $this->setAuthentication()->setJson($planRequest->toArray());

        return new PatchResponse($this->client->execute());
    }
}
