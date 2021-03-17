<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class ApplicationContext
{
    private string $returnUrl;
    private string $cancelUrl;
    private ?string $brandName = null;
    private ?string $locale = null;
    private ?string $shippingPreference = null;
    private ?string $userAction = null;
    private ?PaymentMethod $paymentMethod = null;

    public function __construct(string $returnUrl, string $cancelUrl)
    {
        $this->returnUrl = $returnUrl;
        $this->cancelUrl = $cancelUrl;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(?string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getShippingPreference(): ?string
    {
        return $this->shippingPreference;
    }

    public function setShippingPreference(?string $shippingPreference): self
    {
        $this->shippingPreference = $shippingPreference;

        return $this;
    }

    public function getUserAction(): ?string
    {
        return $this->userAction;
    }

    public function setUserAction(?string $userAction): self
    {
        $this->userAction = $userAction;

        return $this;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    public function setReturnUrl(string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    public function setCancelUrl(string $cancelUrl): self
    {
        $this->cancelUrl = $cancelUrl;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'return_url' => $this->returnUrl,
            'cancel_url' => $this->cancelUrl
        ];

        if ($this->brandName) {
            $data['brand_name'] = $this->brandName;
        }

        if ($this->locale) {
            $data['locale'] = $this->locale;
        }

        if ($this->shippingPreference) {
            $data['shipping_preference'] = $this->shippingPreference;
        }

        if ($this->userAction) {
            $data['user_action'] = $this->userAction;
        }

        if ($this->paymentMethod) {
            $data['payment_method'] = $this->paymentMethod->toArray();
        }

        return $data;
    }
}
