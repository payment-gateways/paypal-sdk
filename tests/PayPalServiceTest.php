<?php

namespace PaymentGateway\PayPalSdk\Tests;

use PaymentGateway\PayPalSdk\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Constants\ProductType;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Requests\UpdateProductRequest;
use PaymentGateway\PayPalSdk\Tests\Mocks\PayPalApi;
use PaymentGateway\PayPalSdk\Tests\Mocks\Responses\PayPalApiResponse;
use PHPUnit\Framework\TestCase;

class PayPalServiceTest extends TestCase
{
    protected $username = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
    protected $password = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';
    protected $baseUri = 'https://api.sandbox.paypal.com';

    /**
     * @test
     */
    public function itCanGetTheAuthToken()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $service->withHandler(new PayPalApi());
        $response = $service->getToken();

        $this->assertArrayHasKey('scope', $response);
        $this->assertArrayHasKey('access_token', $response);
        $this->assertArrayHasKey('token_type', $response);
        $this->assertArrayHasKey('app_id', $response);
        $this->assertArrayHasKey('expires_in', $response);
        $this->assertArrayHasKey('nonce', $response);
    }

    /**
     * @test
     */
    public function itCanCreateAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApi();
        $service->withHandler($payPalApi);

        $product = new StoreProductRequest('My new product', ProductType::SERVICE);
        $product->setDescription('product description')
            ->setCategory(ProductCategory::SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $response = $service->createProduct($product);

        $products = $payPalApi->getProducts();
        $prod = array_shift($products);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame(PayPalApiResponse::productCreated($product->toArray()), $response->parseJson());
        $this->assertSame('My new product', $prod['name']);
        $this->assertSame('product description', $prod['description']);
        $this->assertSame(ProductCategory::SOFTWARE, $prod['category']);
        $this->assertSame('https://example.com/productimage.jpg', $prod['image_url']);
        $this->assertSame('https://example.com', $prod['home_url']);
    }

    /**
     * @test
     */
    public function itCanGetTheProductList()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $service->withHandler(new PayPalApi());

        $response = $service->getProducts();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(PayPalApiResponse::productList(), $response->parseJson());
    }

    /**
     * @test
     */
    public function itCanUpdateAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApi();
        $prod = $payPalApi->loadProduct(['name' => 'New product', 'type' => ProductType::SERVICE]);
        $service->withHandler($payPalApi);

        $product = new UpdateProductRequest($prod['id']);
        $product->setDescription('product description')
            ->setCategory(ProductCategory::ACADEMIC_SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $response = $service->updateProduct($product);

        $this->assertSame(204, $response->getStatusCode());
        $this->assertSame('product description', $payPalApi->getProduct($prod['id'])['description']);
        $this->assertSame(ProductCategory::ACADEMIC_SOFTWARE, $payPalApi->getProduct($prod['id'])['category']);
        $this->assertSame('https://example.com/productimage.jpg', $payPalApi->getProduct($prod['id'])['image_url']);
        $this->assertSame('https://example.com', $payPalApi->getProduct($prod['id'])['home_url']);
    }
}
