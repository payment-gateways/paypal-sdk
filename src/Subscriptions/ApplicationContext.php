<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class ApplicationContext
{
    private ?string $brandName = null;
    private ?string $locale = null;
    private ?string $shippingPreference = null;
    private ?string $userAction = null;
    private ?PaymentMethod $paymentMethod = null;
    private string $returnUrl;
    private string $cancelUrl;

    public function __construct(string $returnUrl, string $cancelUrl)
    {
        $this->returnUrl = $returnUrl;
        $this->cancelUrl = $cancelUrl;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(?string $brandName): void
    {
        $this->brandName = $brandName;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): void
    {
        $this->locale = $locale;
    }

    public function getShippingPreference(): ?string
    {
        return $this->shippingPreference;
    }

    /**
     * @param string|null $shippingPreference
     */
    public function setShippingPreference(?string $shippingPreference): void
    {
        $this->shippingPreference = $shippingPreference;
    }

    public function getUserAction(): ?string
    {
        return $this->userAction;
    }

    public function setUserAction(?string $userAction): void
    {
        $this->userAction = $userAction;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    public function setReturnUrl(string $returnUrl): void
    {
        $this->returnUrl = $returnUrl;
    }

    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    public function setCancelUrl(string $cancelUrl): void
    {
        $this->cancelUrl = $cancelUrl;
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
