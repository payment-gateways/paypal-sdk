<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\Concerns;

use PaymentGateway\PayPalSdk\Subscriptions\PaymentPreferences;

trait HasPaymentPreferences
{
    protected PaymentPreferences $paymentPreferences;

    public function getPaymentPreferences(): PaymentPreferences
    {
        return $this->paymentPreferences;
    }

    public function setPaymentPreferences(PaymentPreferences $paymentPreferences): self
    {
        $this->paymentPreferences = $paymentPreferences;

        return $this;
    }
}
