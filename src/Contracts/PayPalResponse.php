<?php

namespace PaymentGateway\PayPalSdk\Contracts;

use EasyHttp\LayerContracts\Contracts\HttpClientResponse;

interface PayPalResponse
{
    public function isSuccessful(): bool;
    public function getResponse(): HttpClientResponse;
    public function toArray(): array;
}
