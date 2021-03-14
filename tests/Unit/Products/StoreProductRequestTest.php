<?php

namespace PaymentGateway\PayPalSdk\Tests\Unit\Products;

use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Constants\ProductType;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Tests\TestCase;

class StoreProductRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $request = new StoreProductRequest('My product', ProductType::SERVICE);

        $this->assertSame(['name' => 'My product', 'type' => ProductType::SERVICE], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithProductData()
    {
        $request = new StoreProductRequest('My product', ProductType::SERVICE);
        $request->setProductDescription('description');
        $request->setProductCategory(ProductCategory::SOFTWARE);
        $request->setImageUrl('http://image.com');
        $request->setHomeUrl('http://home.com');

        $this->assertSame(
            [
                'name' => 'My product',
                'type' => ProductType::SERVICE,
                'description' => 'description',
                'category' => ProductCategory::SOFTWARE,
                'image_url' => 'http://image.com',
                'home_url' => 'http://home.com',
            ],
            $request->toArray()
        );
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $name = $this->faker->name;
        $type = ProductType::PHYSICAL;
        $description = $this->faker->paragraph;
        $category = ProductCategory::ACCESSORIES;
        $imageUrl = $this->faker->url;
        $homeUrl = $this->faker->url;

        $request = new StoreProductRequest('My product', ProductType::SERVICE);
        $request->setProductName($name);
        $request->setProductType($type);
        $request->setProductDescription($description);
        $request->setProductCategory($category);
        $request->setImageUrl($imageUrl);
        $request->setHomeUrl($homeUrl);

        $this->assertSame($name, $request->getProductName());
        $this->assertSame($type, $request->getProductType());
        $this->assertSame($description, $request->getProductDescription());
        $this->assertSame($category, $request->getProductCategory());
        $this->assertSame($imageUrl, $request->getImageUrl());
        $this->assertSame($homeUrl, $request->getHomeUrl());
        $this->assertSame(
            [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'category' => $category,
                'image_url' => $imageUrl,
                'home_url' => $homeUrl,
            ],
            $request->toArray()
        );
    }
}
