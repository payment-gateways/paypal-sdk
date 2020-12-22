<?php

namespace PaymentGateway\PayPalSdk\Responses;

class PatchResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->response->getStatusCode() === 204;
    }
}
