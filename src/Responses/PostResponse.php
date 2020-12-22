<?php

namespace PaymentGateway\PayPalSdk\Responses;

class PostResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->response->getStatusCode() === 201;
    }
}
