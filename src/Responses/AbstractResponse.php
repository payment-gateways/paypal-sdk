<?php

namespace PaymentGateway\PayPalSdk\Responses;

use EasyHttp\LayerContracts\Contracts\HttpClientResponse;
use EasyHttp\LayerContracts\Exceptions\ImpossibleToParseJsonException;
use PaymentGateway\PayPalSdk\Contracts\PayPalResponse;

abstract class AbstractResponse implements PayPalResponse
{
    protected HttpClientResponse $response;

    public function __construct(HttpClientResponse $response)
    {
        $this->response = $response;
    }

    public function getResponse(): HttpClientResponse
    {
        return $this->response;
    }

    public function toArray(): array
    {
        try {
            return $this->response->parseJson();
        } catch (ImpossibleToParseJsonException $e) {
            return [];
        }
    }
}
