<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\Requests;

use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\Money;
use PaymentGateway\PayPalSdk\Subscriptions\Subscriber;

class StoreSubscriptionRequest
{
    private string $planId;
    private ?string $startTime = null;
    private ?string $quantity = null;
    private ?Money $shippingAmount = null;
    private ?Subscriber $subscriber = null;
    private ?ApplicationContext $applicationContext = null;
    private ?string $customId = null;

    public function __construct(string $planId)
    {
        $this->planId = $planId;
    }

    public function getPlanId(): string
    {
        return $this->planId;
    }

    public function setPlanId(string $planId): self
    {
        $this->planId = $planId;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(?string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getShippingAmount(): ?Money
    {
        return $this->shippingAmount;
    }

    public function setShippingAmount(?Money $shippingAmount): self
    {
        $this->shippingAmount = $shippingAmount;

        return $this;
    }

    public function getSubscriber(): ?Subscriber
    {
        return $this->subscriber;
    }

    public function setSubscriber(?Subscriber $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    public function getApplicationContext(): ?ApplicationContext
    {
        return $this->applicationContext;
    }

    public function setApplicationContext(?ApplicationContext $applicationContext): self
    {
        $this->applicationContext = $applicationContext;

        return $this;
    }

    public function getCustomId(): ?string
    {
        return $this->customId;
    }

    public function setCustomId(?string $customId): self
    {
        $this->customId = $customId;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'plan_id' => $this->planId,
        ];

        if ($this->startTime) {
            $data['start_time'] = $this->startTime;
        }

        if ($this->quantity) {
            $data['quantity'] = $this->quantity;
        }

        if ($this->shippingAmount) {
            $data['shipping_amount'] = $this->shippingAmount->toArray();
        }

        if ($this->subscriber) {
            $data['subscriber'] = $this->subscriber->toArray();
        }

        if ($this->applicationContext) {
            $data['application_context'] = $this->applicationContext->toArray();
        }

        if ($this->customId) {
            $data['custom_id'] = $this->customId;
        }

        return $data;
    }
}
