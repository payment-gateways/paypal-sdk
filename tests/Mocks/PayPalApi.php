<?php

namespace PaymentGateway\PayPalSdk\Tests\Mocks;

use GuzzleHttp\Promise\PromiseInterface;
use PaymentGateway\PayPalSdk\Constants\ProductType;
use PaymentGateway\PayPalSdk\Tests\Mocks\Concerns\HasBasicAuthentication;
use PaymentGateway\PayPalSdk\Tests\Mocks\Concerns\HasBearerAuthentication;
use PaymentGateway\PayPalSdk\Tests\Mocks\Concerns\HasFixedResponse;
use PaymentGateway\PayPalSdk\Tests\Mocks\Responses\PayPalApiResponse;
use Psr\Http\Message\RequestInterface;

class PayPalApi extends BaseMock
{
    use HasFixedResponse;
    use HasBasicAuthentication;
    use HasBearerAuthentication;

    protected $hostname = 'api.sandbox.paypal.com';

    protected $user = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
    protected $pass = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';

    protected $products = [];

    protected ?PromiseInterface $response = null;

    public function loadProduct($request): array
    {
        $product = PayPalApiResponse::productCreated($request);
        $this->products[] = $product;

        return $product;
    }

    public function getProduct($id): ?array
    {
        $position = $this->arrayPos(array_column($this->products, 'id'), $id);

        if ($position !== false) {
            return $this->products[$position];
        }

        return null;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function __invoke(RequestInterface $request)
    {
        if ($this->fixedResponse) {
            return $this->fixedResponse;
        }

        if ($request->getUri()->getHost() != $this->hostname) {
            return $this->jsonResponse(400, 'Not found');
        }

        $this->response = $this->jsonResponse(400, 'Not found');

        if ($request->getUri()->getPath() === '/v1/oauth2/token') {
            if ($request->getMethod() === 'GET') {
                $this->invalidToken();
            } elseif (!$this->validateBasicAuth($request)) {
                $this->failureAuthentication();
            } elseif (empty($request->getUri()->getQuery())) {
                $this->unsupportedGrantType();
            } else {
                $this->token();
            }
        } elseif ($request->getUri()->getPath() === '/v1/catalogs/products') {
            if ($request->getMethod() === 'GET') {
                if (!$this->validateAuthToken($request)) {
                    $this->failureAuthentication();
                } else {
                    $this->productList();
                }
            } elseif ($request->getMethod() === 'POST') {
                if (!$this->validateAuthToken($request)) {
                    $this->failureAuthentication();
                } else {
                    $json = $this->parseArray(json_decode($request->getBody()->getContents()));
                    $this->createProduct($json);
                }
            } else {
                $this->response = $this->response(404, '');
            }
        } elseif (preg_match('/v1\/catalogs\/products\/(PROD-[0-9a-zA-Z]+)/', $request->getUri()->getPath(), $matches)) {
            if ($request->getMethod() === 'PATCH') {
                $id = $matches[1];

                if (!in_array($id, array_column($this->products, 'id'))) {
                    $this->response = $this->response(404, '', [], 'Not Found');
                } else {
                    $json = $this->parseArray(json_decode($request->getBody()->getContents()));

                    $ids = array_column($this->products, 'id');
                    $position = $this->arrayPos($ids, $id);

                    foreach ($json as $change) {
                        $field = str_replace('/', '', $change['path']);

                        if ($change['op'] === 'add') {
                            $this->products[$position][$field] = $this->products[$id][$field] . $change['value'];
                        } elseif ($change['op'] === 'replace') {
                            $this->products[$position][$field] = $change['value'];
                        } elseif ($change['op'] === 'remove') {
                            unset($this->products[$position][$field]);
                        }
                    }

                    $this->response = $this->response(204, '', [], 'No Content');
                }
            } else {
                $this->response = $this->response(405, '', [], 'Method Not Allowed');
            }
        }

        return $this->response;
    }

    /**
     * @param $obj
     * @return array|object
     */
    private function parseArray($obj)
    {
        if (is_object($obj)) {
            $obj = (array) $obj;
        }

        if (is_array($obj)) {
            $new = array();

            foreach ($obj as $key => $val) {
                $new[$key] = $this->parseArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }

    private function arrayPos(array $array, $element)
    {
        foreach ($array as $key => $value) {
            if ($value === $element) {
                return $key;
            }
        }

        return false;
    }

    private function token(): void
    {
        $this->response = $this->jsonResponse(200, PayPalApiResponse::token(), [], 'OK');
    }

    private function invalidToken(): void
    {
        $this->response = $this->jsonResponse(401, PayPalApiResponse::invalidToken(), [], 'OK');
    }

    private function failureAuthentication(): void
    {
        $this->response = $this->jsonResponse(401, PayPalApiResponse::failureAuthentication(), [], 'OK');
    }

    private function unsupportedGrantType(): void
    {
        $this->response = $this->jsonResponse(401, PayPalApiResponse::missingGrantType(), [], 'OK');
    }

    private function createProduct(array $request): void
    {
        if (!isset($request['name'])) {
            $this->response = $this->jsonResponse(400, PayPalApiResponse::missingRequiredParameter('name'));
            return;
        }

        if (!isset($request['type'])) {
            $request['type'] = ProductType::PHYSICAL;
        }

        $product = PayPalApiResponse::productCreated($request);
        $this->products[] = $product;

        $this->response = $this->jsonResponse(201, $product, [], 'OK');
    }

    private function productList(): void
    {
        $this->response = $this->jsonResponse(200, PayPalApiResponse::productList(), [], 'OK');
    }
}
