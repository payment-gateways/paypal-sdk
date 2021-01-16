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

    public function setPlanId(string $planId): void
    {
        $this->planId = $planId;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(?string $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getShippingAmount(): ?Money
    {
        return $this->shippingAmount;
    }

    public function setShippingAmount(?Money $shippingAmount): void
    {
        $this->shippingAmount = $shippingAmount;
    }

    public function getSubscriber(): ?Subscriber
    {
        return $this->subscriber;
    }

    public function setSubscriber(?Subscriber $subscriber): void
    {
        $this->subscriber = $subscriber;
    }

    public function getApplicationContext(): ?ApplicationContext
    {
        return $this->applicationContext;
    }

    public function setApplicationContext(?ApplicationContext $applicationContext): void
    {
        $this->applicationContext = $applicationContext;
    }

    public function getCustomId(): ?string
    {
        return $this->customId;
    }

    public function setCustomId(?string $customId): void
    {
        $this->customId = $customId;
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
