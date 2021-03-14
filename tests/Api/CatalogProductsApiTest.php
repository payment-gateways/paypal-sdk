<?php

namespace PaymentGateway\PayPalSdk\Tests\Api;

use EasyHttp\MockBuilder\HttpMock;
use PaymentGateway\PayPalSdk\Api\CatalogProductsApi;
use PaymentGateway\PayPalSdk\Products\Constants\ProductCategory;
use PaymentGateway\PayPalSdk\Products\Constants\ProductType;
use PaymentGateway\PayPalSdk\Products\Requests\StoreProductRequest;
use PaymentGateway\PayPalSdk\Products\Requests\UpdateProductRequest;
use PaymentGateway\PayPalSdk\Tests\Api\Concerns\HasMockBuilder;
use PHPUnit\Framework\TestCase;

class CatalogProductsApiTest extends TestCase
{
    use HasMockBuilder;

    protected string $baseUri = 'https://api.sandbox.paypal.com';

    public function setUp(): void
    {
        $this->createBuilder();
        parent::setUp();
    }

    /**
     * @test
     */
    public function itCanGetAProduct()
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v1\/catalogs\/products\/(PROD-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(200)
                ->json([
                    'id' => 'PROD-49A80826MF300605W',
                    'name' => 'Product name',
                    'type' => ProductType::SERVICE,
                ]);

        $service = new CatalogProductsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getProduct('PROD-49A80826MF300605W');
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame('PROD-49A80826MF300605W', $json['id']);
        $this->assertSame('Product name', $json['name']);
    }


    /**
     * @test
     */
    public function itCanGetTheProductList()
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathIs('/v1/catalogs/products')
            ->then()
                ->statusCode(200)
                ->json([
                    'products' => [
                        [
                            'id' => 'PROD-3S7747590U1054105',
                            'name' => 'Product name',
                        ]
                    ],
                ]);

        $service = new CatalogProductsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getProducts();
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertArrayHasKey('products', $json);
        $this->assertSame('Product name', $json['products'][0]['name']);
    }

    /**
     * @test
     */
    public function itCanCreateAProductWithOnlyRequiredParameters()
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v1/catalogs/products')
            ->then()
                ->statusCode(201)
                ->json([
                    'id' => 'PROD-57047116WT127093F',
                    'name' => 'Product name',
                ]);

        $service = new CatalogProductsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $product = new StoreProductRequest('Product name', ProductType::SERVICE);
        $response = $service->createProduct($product);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertSame('Product name', $json['name']);
    }

    /**
     * @test
     */
    public function itCanCreateAProduct()
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v1/catalogs/products')
            ->then()
                ->statusCode(201)
                ->json([
                    'id' => 'PROD-57047116WT127093F',
                    'name' => 'Product name',
                ]);

        $service = new CatalogProductsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $product = new StoreProductRequest('My new product', ProductType::SERVICE);
        $product->setProductDescription('product description')
            ->setProductCategory(ProductCategory::SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $response = $service->createProduct($product);
        $json = $response->toArray();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(201, $response->getResponse()->getStatusCode());
        $this->assertSame('Product name', $json['name']);
    }

    /**
     * @test
     */
    public function itCanUpdateAProductWithOnlyRequiredParameters()
    {
        $this->builder
            ->when()
                ->methodIs('PATCH')
                ->pathMatch('/v1\/catalogs\/products\/(PROD-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(204);

        $service = new CatalogProductsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $productRequest = new UpdateProductRequest('PROD-57047116WT127093F');

        $response = $service->updateProduct($productRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function itCanUpdateAProduct()
    {
        $this->builder
            ->when()
                ->methodIs('PATCH')
                ->pathMatch('/v1\/catalogs\/products\/(PROD-[0-9a-zA-Z]+)/')
            ->then()
                ->statusCode(204);

        $service = new CatalogProductsApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $productRequest = new UpdateProductRequest('PROD-57047116WT127093F');
        $productRequest->setProductDescription('product description')
            ->setProductCategory(ProductCategory::ACADEMIC_SOFTWARE)
            ->setImageUrl('https://example.com/productimage.jpg')
            ->setHomeUrl('https://example.com');

        $response = $service->updateProduct($productRequest);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(204, $response->getResponse()->getStatusCode());
    }
}
