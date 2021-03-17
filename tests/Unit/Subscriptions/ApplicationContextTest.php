<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\ApplicationContext;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\ShippingPreference;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\UserAction;
use PaymentGateway\PayPalSdk\Subscriptions\PaymentMethod;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class ApplicationContextTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithMinimumData()
    {
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);

        $this->assertSame([
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
        ], $applicationContext->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithBrandNameData()
    {
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);
        $applicationContext->setBrandName('Brand');

        $this->assertSame([
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'brand_name' => 'Brand'
        ], $applicationContext->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithLocaleData()
    {
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);
        $applicationContext->setLocale('ja-JP');

        $this->assertSame([
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'locale' => 'ja-JP'
        ], $applicationContext->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithShippingPreferenceData()
    {
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);
        $applicationContext->setShippingPreference(ShippingPreference::GET_FROM_FILE);

        $this->assertSame([
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'shipping_preference' => ShippingPreference::GET_FROM_FILE
        ], $applicationContext->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithUserActionData()
    {
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);
        $applicationContext->setUserAction(UserAction::CONTINUE);

        $this->assertSame([
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'user_action' => UserAction::CONTINUE
        ], $applicationContext->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPaymentMethodData()
    {
        $returnUrl = $this->faker->url;
        $cancelUrl = $this->faker->url;
        $applicationContext = new ApplicationContext($returnUrl, $cancelUrl);
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setPayerSelected('PAYPAL');
        $applicationContext->setPaymentMethod($paymentMethod);

        $this->assertSame([
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'payment_method' => $paymentMethod->toArray()
        ], $applicationContext->toArray());
    }
}
