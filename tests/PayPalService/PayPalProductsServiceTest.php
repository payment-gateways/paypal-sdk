<?php

namespace PaymentGateway\PayPalSdk\Tests\PayPalService;

use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Constants\ProductType;
use PaymentGateway\PayPalSdk\PayPalService;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Products\Requests\UpdateProductRequest;
use PaymentGateway\PayPalSdk\Tests\Mocks\PayPalApi\PayPalApiMock;
use PaymentGateway\PayPalSdk\Tests\PayPalService\Concerns\HasProduct;
use PHPUnit\Framework\TestCase;

class PayPalProductsServiceTest extends TestCase
{
    use HasProduct;

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
        $service->withHandler(new PayPalApiMock());
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
    public function itCanCreateAProductWithOnlyRequiredParameters()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);

        $product = new StoreProductRequest('My new product', ProductType::SERVICE);

        $payPalApi = new PayPalApiMock();
        $service->withHandler($payPalApi);
        $response = $service->createProduct($product);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertSame('My new product', $json['name']);
    }

    /**
     * @test
     */
    public function itCanCreateAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);

        $product = new StoreProductRequest('My new product', ProductType::SERVICE);
        $product->setDescription('product description')
            ->setCategory(ProductCategory::SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $payPalApi = new PayPalApiMock();
        $service->withHandler($payPalApi);
        $response = $service->createProduct($product);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertSame('My new product', $json['name']);
        $this->assertSame('product description', $json['description']);
        $this->assertSame(ProductCategory::SOFTWARE, $json['category']);
        $this->assertSame('https://example.com/productimage.jpg', $json['image_url']);
        $this->assertSame('https://example.com', $json['home_url']);
    }

    /**
     * @test
     */
    public function itCanGetTheProductList()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $product = $this->fakeProduct($service);

        $response = $service->getProducts();
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('products', $json);
        $this->assertSame($product['name'], $json['products'][0]['name']);
    }

    /**
     * @test
     */
    public function itCanGetAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);

        $response = $service->getProduct($product['id']);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($product['id'], $json['id']);
        $this->assertSame($product['name'], $json['name']);
    }

    /**
     * @test
     */
    public function itCanUpdateAProduct()
    {
        $service = new PayPalService($this->baseUri);
        $service->setAuth($this->username, $this->password);
        $payPalApi = new PayPalApiMock();
        $product = $this->fakeProduct($service, $payPalApi);

        $productRequest = new UpdateProductRequest($product['id']);
        $productRequest->setDescription('product description')
            ->setCategory(ProductCategory::ACADEMIC_SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $response = $service->updateProduct($productRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
        $this->assertSame('product description', $payPalApi->getProduct($product['id'])['description']);
        $this->assertSame(ProductCategory::ACADEMIC_SOFTWARE, $payPalApi->getProduct($product['id'])['category']);
        $this->assertSame('https://example.com/productimage.jpg', $payPalApi->getProduct($product['id'])['image_url']);
        $this->assertSame('https://example.com', $payPalApi->getProduct($product['id'])['home_url']);
    }
}
