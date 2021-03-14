<?php

namespace PaymentGateway\PayPalSdk\Api;

use PaymentGateway\PayPalSdk\Contracts\PayPalResponse;
use PaymentGateway\PayPalSdk\PayPalApi;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Products\Requests\UpdateProductRequest;
use PaymentGateway\PayPalSdk\Responses\GetResponse;
use PaymentGateway\PayPalSdk\Responses\PatchResponse;
use PaymentGateway\PayPalSdk\Responses\PostResponse;

class CatalogProductsApi extends PayPalApi
{
    public function getProduct(string $id): PayPalResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/catalogs/products/' . $id);
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function getProducts(): PayPalResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v1/catalogs/products');
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function createProduct(StoreProductRequest $product): PayPalResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v1/catalogs/products');
        $this->setAuthentication()->setJson($product->toArray());

        return new PostResponse($this->client->execute());
    }

    public function updateProduct(UpdateProductRequest $productRequest): PayPalResponse
    {
        $this->client->prepareRequest('PATCH', $this->baseUri . '/v1/catalogs/products/' . $productRequest->getId());
        $this->setAuthentication()->setJson($productRequest->toArray());

        return new PatchResponse($this->client->execute());
    }
}
