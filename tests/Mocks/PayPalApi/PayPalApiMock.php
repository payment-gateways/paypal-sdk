<?php

namespace PaymentGateway\PayPalSdk\Tests\Mocks\PayPalApi;

use GuzzleHttp\Promise\PromiseInterface;
use PaymentGateway\PayPalSdk\Constants\ProductType;
use PaymentGateway\PayPalSdk\Subscriptions\Constants\PlanStatus;
use PaymentGateway\PayPalSdk\Tests\Mocks\BaseMock;
use PaymentGateway\PayPalSdk\Tests\Mocks\Concerns\HasBasicAuthentication;
use PaymentGateway\PayPalSdk\Tests\Mocks\Concerns\HasBearerAuthentication;
use PaymentGateway\PayPalSdk\Tests\Mocks\Concerns\HasFixedResponse;
use PaymentGateway\PayPalSdk\Tests\Mocks\Responses\PayPalApiResponse;
use Psr\Http\Message\RequestInterface;

class PayPalApiMock extends BaseMock
{
    use HasFixedResponse;
    use HasBasicAuthentication;
    use HasBearerAuthentication;

    private const PRODUCT_PATTERN = '/v1\/catalogs\/products\/(PROD-[0-9a-zA-Z]+)/';
    private const PLAN_PATTERN = '/v1\/billing\/plans\/(P-[0-9a-zA-Z]+)/';

    protected $hostname = 'api.sandbox.paypal.com';

    protected $user = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
    protected $pass = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';

    protected $products = [];
    protected $plans = [];

    protected ?PromiseInterface $response = null;

    public function getProduct(string $id): ?array
    {
        return $this->showProduct($id);
    }

    public function getPlan(string $id): array
    {
        return $this->showPlan($id);
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
                    $this->productListResponse();
                }
            } elseif ($request->getMethod() === 'POST') {
                if (!$this->validateAuthToken($request)) {
                    $this->failureAuthentication();
                } else {
                    $json = $this->parseArray(json_decode($request->getBody()->getContents()));
                    $this->createProduct($json);
                }
            } else {
                $this->response = $this->response(404, '', [], 'Not Found');
            }
        } elseif (preg_match(self::PRODUCT_PATTERN, $request->getUri()->getPath(), $matches)) {
            if ($request->getMethod() === 'GET') {
                $id = $matches[1];

                if (!in_array($id, array_column($this->products, 'id'))) {
                    $this->response = $this->response(
                        404,
                        PayPalApiResponse::resourceNotFound('product id'),
                        [],
                        'Not Found'
                    );
                } else {
                    $this->showProductResponse($id);
                }
            } elseif ($request->getMethod() === 'PATCH') {
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
        } elseif ($request->getUri()->getPath() === '/v1/billing/plans') {
            if ($request->getMethod() === 'GET') {
                if (!$this->validateAuthToken($request)) {
                    $this->failureAuthentication();
                } else {
                    $this->planListResponse();
                }
            } elseif ($request->getMethod() === 'POST') {
                if (!$this->validateAuthToken($request)) {
                    $this->failureAuthentication();
                } else {
                    $json = $this->parseArray(json_decode($request->getBody()->getContents()));
                    $this->createPlan($json);
                }
            } else {
                $this->response = $this->response(405, '', [], 'Method Not Allowed');
            }
        } elseif (preg_match(self::PLAN_PATTERN, $request->getUri()->getPath(), $matches)) {
            if ($request->getMethod() === 'GET') {
                $id = $matches[1];

                if (!in_array($id, array_column($this->plans, 'id'))) {
                    $this->response = $this->response(
                        404,
                        PayPalApiResponse::resourceNotFound('planId'),
                        [],
                        'Not Found'
                    );
                } else {
                    $this->showPlanResponse($id);
                }
            } elseif (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS'])) {
                $this->response = $this->response(404, '', [], 'Not Found');
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

    private function productList(): array
    {
        $list = ['products' => []];

        foreach ($this->products as $product) {
            unset($product['type']);
            $list['products'][] = $product;
        }

        return $list;
    }

    private function productListResponse(): void
    {
        $this->response = $this->jsonResponse(200, $this->productList(), [], 'OK');
    }

    private function showProduct(string $id): array
    {
        $ids = array_column($this->products, 'id');
        $position = $this->arrayPos($ids, $id);

        return $this->products[$position];
    }

    private function showProductResponse(string $id): void
    {
        $this->response = $this->jsonResponse(200, $this->showProduct($id), [], 'OK');
    }

    private function createPlan(array $request): void
    {
        if (!isset($request['name'])) {
            $this->response = $this->jsonResponse(
                400,
                PayPalApiResponse::missingRequiredParameter('name'),
                [],
                'Bad Request'
            );
            return;
        }

        if (!isset($request['payment_preferences'])) {
            $this->response = $this->jsonResponse(
                400,
                PayPalApiResponse::missingRequiredParameter('payment_preferences'),
                [],
                'Bad Request'
            );
            return;
        }

        if (!isset($request['status'])) {
            $request['status'] = PlanStatus::ACTIVE;
        }

        $plan = PayPalApiResponse::planCreated($request);
        $this->plans[] = $plan;

        $this->response = $this->jsonResponse(201, $plan, [], 'Created');
    }

    private function planList(): array
    {
        $list = ['plans' => []];

        foreach ($this->plans as $plan) {
            unset($plan['product_id']);
            $plan['links'] = $plan['links'][0];
            $list['plans'][] = $plan;
        }

        return $list;
    }

    private function planListResponse(): void
    {
        $this->response = $this->jsonResponse(200, $this->planList(), [], 'OK');
    }

    private function showPlan(string $id): array
    {
        $ids = array_column($this->plans, 'id');
        $position = $this->arrayPos($ids, $id);

        return $this->plans[$position];
    }

    private function showPlanResponse(string $id): void
    {
        $this->response = $this->jsonResponse(200, $this->showPlan($id), [], 'OK');
    }
}
