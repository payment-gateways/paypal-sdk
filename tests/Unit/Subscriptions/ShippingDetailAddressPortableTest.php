<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Subscriptions;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\CountryCode;
use PaymentGateway\PayPalSdk\Subscriptions\ShippingDetailAddressPortable;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class ShippingDetailAddressPortableTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnArrayWithMinimumData()
    {
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);

        $this->assertSame(['country_code' => CountryCode::UNITED_ARAB_EMIRATES], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAddressLine1Data()
    {
        $address = $this->faker->address;
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);
        $shippingAddress->setAddressLine1($address);

        $this->assertSame([
            'country_code' => CountryCode::UNITED_ARAB_EMIRATES,
            'address_line_1' => $address
        ], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAddressLine2Data()
    {
        $address = $this->faker->address;
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);
        $shippingAddress->setAddressLine2($address);

        $this->assertSame([
            'country_code' => CountryCode::UNITED_ARAB_EMIRATES,
            'address_line_2' => $address
        ], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAdminArea1Data()
    {
        $area = $this->faker->word;
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);
        $shippingAddress->setAdminArea1($area);

        $this->assertSame([
            'country_code' => CountryCode::UNITED_ARAB_EMIRATES,
            'admin_area_1' => $area
        ], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAdminArea2Data()
    {
        $area = $this->faker->word;
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);
        $shippingAddress->setAdminArea2($area);

        $this->assertSame([
            'country_code' => CountryCode::UNITED_ARAB_EMIRATES,
            'admin_area_2' => $area
        ], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithPostalCodeData()
    {
        $postcode = $this->faker->postcode;
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);
        $shippingAddress->setPostalCode($postcode);

        $this->assertSame([
            'country_code' => CountryCode::UNITED_ARAB_EMIRATES,
            'postal_code' => $postcode
        ], $shippingAddress->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $address1 = $this->faker->address;
        $address2 = $this->faker->address;
        $area1 = $this->faker->word;
        $area2 = $this->faker->word;
        $postcode = $this->faker->postcode;
        $shippingAddress = new ShippingDetailAddressPortable(CountryCode::UNITED_ARAB_EMIRATES);
        $shippingAddress->setAddressLine1($address1);
        $shippingAddress->setAddressLine2($address2);
        $shippingAddress->setAdminArea1($area1);
        $shippingAddress->setAdminArea2($area2);
        $shippingAddress->setPostalCode($postcode);

        $this->assertSame($address1, $shippingAddress->getAddressLine1());
        $this->assertSame($address2, $shippingAddress->getAddressLine2());
        $this->assertSame($area1, $shippingAddress->getAdminArea1());
        $this->assertSame($area2, $shippingAddress->getAdminArea2());
        $this->assertSame($postcode, $shippingAddress->getPostalCode());

        $address1 = $this->faker->address;
        $address2 = $this->faker->address;
        $area1 = $this->faker->word;
        $area2 = $this->faker->word;
        $postcode = $this->faker->postcode;
        $shippingAddress->setCountryCode(CountryCode::CANADA);
        $shippingAddress->setAddressLine1($address1);
        $shippingAddress->setAddressLine2($address2);
        $shippingAddress->setAdminArea1($area1);
        $shippingAddress->setAdminArea2($area2);
        $shippingAddress->setPostalCode($postcode);

        $this->assertSame(CountryCode::CANADA, $shippingAddress->getCountryCode());
        $this->assertSame($address1, $shippingAddress->getAddressLine1());
        $this->assertSame($address2, $shippingAddress->getAddressLine2());
        $this->assertSame($area1, $shippingAddress->getAdminArea1());
        $this->assertSame($area2, $shippingAddress->getAdminArea2());
        $this->assertSame($postcode, $shippingAddress->getPostalCode());
    }
}
