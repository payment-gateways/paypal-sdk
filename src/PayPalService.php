<?php

namespace PaymentGateway\PayPalSdk;

use EasyHttp\GuzzleLayer\GuzzleClient;
use EasyHttp\LayerContracts\Contracts\EasyClientContract;
use EasyHttp\LayerContracts\Contracts\HttpClientResponse;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\StorePlanRequest;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Subscriptions\Requests\UpdatePlanRequest;
use PaymentGateway\PayPalSdk\Products\Requests\UpdateProductRequest;

class PayPalService
{
    protected EasyClientContract $client;
    protected string $baseUri;
    protected string $username;
    protected string $password;
    protected array $token;

    public function __construct(string $baseUri)
    {
        $this->baseUri = $baseUri;
        $this->client = new GuzzleClient();
    }

    public function setAuth(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function withHandler(callable $handler)
    {
        $this->client->withHandler($handler);
    }

    public function getToken(): array
    {
        if ($this->token ?? null) {
            return $this->token;
        }

        $client = clone $this->client;

        $client->prepareRequest('POST', $this->baseUri . '/v1/oauth2/token');
        $client->getRequest()->setBasicAuth($this->username, $this->password);
        $client->getRequest()->setQuery(['grant_type' => 'client_credentials']);

        $this->token = $client->execute()->parseJson();

        return $this->token;
    }

    public function createProduct(StoreProductRequest $product): HttpClientResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v1/catalogs/products');
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);
        $this->client->getRequest()->setJson($product->toArray());

        return $this->client->execute();
    }

    public function getProducts(): HttpClientResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/catalogs/products');
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);

        return $this->client->execute();
    }

    public function getProduct(string $id): HttpClientResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/catalogs/products/' . $id);
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);

        return $this->client->execute();
    }

    public function updateProduct(UpdateProductRequest $productRequest): HttpClientResponse
    {
        $this->client->prepareRequest('PATCH', $this->baseUri . '/v1/catalogs/products/' . $productRequest->getId());
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);
        $this->client->getRequest()->setJson($productRequest->toArray());

        return $this->client->execute();
    }

    public function createPlan(StorePlanRequest $storePlanRequest): HttpClientResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v1/billing/plans');
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);
        $this->client->getRequest()->setJson($storePlanRequest->toArray());

        return $this->client->execute();
    }

    public function getPlans(): HttpClientResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/billing/plans');
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);

        return $this->client->execute();
    }

    public function getPlan(string $id): HttpClientResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/billing/plans/' . $id);
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);

        return $this->client->execute();
    }

    public function updatePlan(UpdatePlanRequest $planRequest): HttpClientResponse
    {
        $this->client->prepareRequest('PATCH', $this->baseUri . '/v1/billing/plans/' . $planRequest->getId());
        $this->client->getRequest()->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);
        $this->client->getRequest()->setJson($planRequest->toArray());

        return $this->client->execute();
    }
}
