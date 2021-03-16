<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Products;

use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Requests\UpdateProductRequest;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class UpdateProductRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $request = new UpdateProductRequest('P-3GM32410SK6114311MAU3BLY');

        $this->assertSame([], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithProductData()
    {
        $description = 'description';
        $category = ProductCategory::ACCOUNTING;
        $imageUrl = $this->faker->url;
        $homeUrl = $this->faker->url;

        $request = new UpdateProductRequest('P-3GM32410SK6114311MAU3BLY');
        $request->setProductDescription($description);
        $request->setProductCategory($category);
        $request->setImageUrl($imageUrl);
        $request->setHomeUrl($homeUrl);

        $this->assertSame(
            [
                [
                    'op' => 'replace',
                    'path' => '/description',
                    'value' => $description
                ],
                [
                    'op' => 'replace',
                    'path' => '/category',
                    'value' => $category
                ],
                [
                    'op' => 'replace',
                    'path' => '/image_url',
                    'value' => $imageUrl
                ],
                [
                    'op' => 'replace',
                    'path' => '/home_url',
                    'value' => $homeUrl
                ],
            ],
            $request->toArray()
        );
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $id = $this->faker->uuid;
        $description = $this->faker->paragraph;
        $category = ProductCategory::ACCESSORIES;
        $imageUrl = $this->faker->url;
        $homeUrl = $this->faker->url;

        $request = new UpdateProductRequest('P-3GM32410SK6114311MAU3BLY');
        $request->setProductId($id);
        $request->setProductDescription($description);
        $request->setProductCategory($category);
        $request->setImageUrl($imageUrl);
        $request->setHomeUrl($homeUrl);

        $this->assertSame($id, $request->getProductId());
        $this->assertSame($description, $request->getProductDescription());
        $this->assertSame($category, $request->getProductCategory());
        $this->assertSame($imageUrl, $request->getImageUrl());
        $this->assertSame($homeUrl, $request->getHomeUrl());

        $this->assertSame(
            [
                [
                    'op' => 'replace',
                    'path' => '/description',
                    'value' => $description
                ],
                [
                    'op' => 'replace',
                    'path' => '/category',
                    'value' => $category
                ],
                [
                    'op' => 'replace',
                    'path' => '/image_url',
                    'value' => $imageUrl
                ],
                [
                    'op' => 'replace',
                    'path' => '/home_url',
                    'value' => $homeUrl
                ],
            ],
            $request->toArray()
        );
    }
}
