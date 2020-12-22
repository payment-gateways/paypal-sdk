<?php

namespace PaymentGateway\PayPalSdk\Responses;

class GetResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->response->getStatusCode() === 200;
    }
}
