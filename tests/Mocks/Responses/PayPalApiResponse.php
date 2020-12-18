<?php

namespace PaymentGateway\PayPalSdk\Tests\Mocks\Responses;

use PaymentGateway\PayPalSdk\Subscriptions\Constants\PlanStatus;

class PayPalApiResponse
{
    public static function token(): array
    {
        return [
            'scope' => 'https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/payments/refund https://api.paypal.com/v1/vault/credit-card https://api.paypal.com/v1/payments/.* https://uri.paypal.com/payments/payouts https://api.paypal.com/v1/vault/credit-card/.* https://uri.paypal.com/services/subscriptions https://uri.paypal.com/services/applications/webhooks', // phpcs:ignore
            'access_token' => 'A21AAK0bqGokMIxVEU2O-x9a04BG0xX6-geO6JmogaA0J3lCHqLKhKWvLWT2NtkP1VUOuWGBsfx3PwiHwBAhwb5UN80TmM65w', // phpcs:ignore
            'token_type' => 'Bearer',
            'app_id' => 'APP-80W284485P519543T',
            'expires_in' => 32358,
            'nonce' => '2020-12-01T00:49:57ZSvHY0k14KHSXBV-6Al4jAhQ-_e5wPsZdAfJuneW911U',
        ];
    }

    public static function failureAuthentication(): array
    {
        return [
            'name' => 'AUTHENTICATION_FAILURE',
            'message' => 'Authentication failed due to invalid authentication credentials or a missing Authorization header.', // phpcs:ignore
            'links' => [
                [
                    'href' => 'https://developer.paypal.com/docs/api/overview/#error',
                    'rel' => 'information_link'
                ]
            ]
        ];
    }

    public static function missingGrantType(): array
    {
        return [
            'error' => 'unsupported_grant_type',
            'error_description' => 'Grant Type is NULL',
        ];
    }

    public static function unsupportedGrantType(): array
    {
        return [
            'error' => 'unsupported_grant_type',
            'error_description' => 'unsupported grant_type',
        ];
    }

    public static function invalidToken(): array
    {
        return [
            'error' => 'invalid_token',
            'error_description' => 'Authorization header does not have valid access token',
        ];
    }

    private static function invalidRequest($issue, $description, $field): array
    {
        return [
            'name' => 'INVALID_REQUEST',
            'message' => 'Request is not well-formed, syntactically incorrect, or violates schema.',
            'debug_id' => uniqid(),
            'details' => [
                [
                    'field' => "/$field",
                    'location' => 'body',
                    'issue' => $issue,
                    'description' => $description
                ]
            ],
            'links' => [
                [
                    'href' => 'https://developer.paypal.com/docs/api/v1/billing/subscriptions#INVALID_REQUEST',
                    'rel' => 'information_link',
                    'method' => 'GET'
                ]
            ]
        ];
    }

    public static function missingRequiredParameter(string $name): array
    {
        return self::invalidRequest('MISSING_REQUIRED_PARAMETER', 'A required field is missing.', $name);
    }

    public static function resourceNotFound($identifier)
    {
        return [
            'name' => 'RESOURCE_NOT_FOUND',
            'message' => 'The specified resource does not exist.',
            'debug_id' => uniqid(),
            'details' => [
                [
                    'issue' => 'INVALID_RESOURCE_ID',
                    'description' => 'Invalid ' . $identifier
                ]
            ],
            'links' => [
                [
                    'href' => 'https://developer.paypal.com/docs/api/v1/billing/subscriptions#RESOURCE_NOT_FOUND',
                    'rel' => 'information_link',
                    'method' => 'GET'
                ]
            ]
        ];
    }

    public static function productCreated(array $request): array
    {
        $id = 'PROD-XY' . substr(bin2hex(uniqid()), 0, 15);

        $product = [
            'id' => $id,
            'name' => $request['name'],
            'type' => $request['type'],
            'create_time' => '2020-01-10T21:20:49Z',
            'update_time' => '2020-01-10T21:20:49Z',
            'links' => [
                [
                    'href' => 'https://api.paypal.com/v1/catalogs/products/' . $id,
                    'rel' => 'self',
                    'method' => 'GET'
                ],
                [
                    'href' => 'https://api.paypal.com/v1/catalogs/products/' . $id,
                    'rel' => 'edit',
                    'method' => 'PATCH'
                ]
            ]
        ];

        if (isset($request['description'])) {
            $product['description'] = $request['description'];
        }

        if (isset($request['category'])) {
            $product['category'] = $request['category'];
        }

        if (isset($request['image_url'])) {
            $product['image_url'] = $request['image_url'];
        }

        if (isset($request['home_url'])) {
            $product['home_url'] = $request['home_url'];
        }

        return $product;
    }

    public static function productList(): array
    {
        return [
            'total_items' => 20,
            'total_pages' => 10,
            'products' => [
                [
                    'id' => '72255d4849af8ed6e0df1173',
                    'name' => 'Video Streaming Service',
                    'description' => 'Video streaming service',
                    'create_time' => '2018-12-10T21:20:49Z',
                    'links' => [
                        [
                            'href' => 'https://api.paypal.com/v1/catalogs/products/72255d4849af8ed6e0df1173',
                            'rel' => 'self',
                            'method' => 'GET'
                        ]
                    ]
                ],
                [
                    'id' => 'PROD-XYAB12ABSB7868434',
                    'name' => 'Video Streaming Service',
                    'description' => 'Audio streaming service',
                    'create_time' => '2018-12-10T21:20:49Z',
                    'links' => [
                        [
                            'href' => 'https://api.paypal.com/v1/catalogs/products/125d4849af8ed6e0df18',
                            'rel' => 'self',
                            'method' => 'GET'
                        ]
                    ]
                ]
            ],
            'links' => [
                [
                    'href' => 'https://api.paypal.com/v1/catalogs/products?page_size=2&page=1',
                    'rel' => 'self',
                    'method' => 'GET'
                ],
                [
                    'href' => 'https://api.paypal.com/v1/catalogs/products?page_size=2&page=2',
                    'rel' => 'next',
                    'method' => 'GET'
                ],
                [
                    'href' => 'https://api.paypal.com/v1/catalogs/products?page_size=2&page=10',
                    'rel' => 'last',
                    'method' => 'GET'
                ]
            ]
        ];
    }

    public static function planCreated(array $request, string $id = ''): array
    {
        if (!$id) {
            $id = 'P-' . substr(bin2hex(uniqid()), 0, 24);
        }

        $product = [
            'id' => $id,
            'product_id' => $request['product_id'],
            'name' => $request['name'],
            'status' => $request['status'] ?? PlanStatus::ACTIVE,
            'usage_type' => 'LICENSED',
            'create_time' => '2020-12-17T03:44:39Z',
            'links' => [
                [
                    'href' =>  "https://api.sandbox.paypal.com/v1/billing/plans/$id",
                    'rel' =>  'self',
                    'method' =>  'GET',
                    'encType' =>  'application/json'
                ],
                [
                    'href' =>  "https://api.sandbox.paypal.com/v1/billing/plans/$id",
                    'rel' =>  'edit',
                    'method' =>  'PATCH',
                    'encType' =>  'application/json'
                ],
                [
                    'href' =>  "https://api.sandbox.paypal.com/v1/billing/plans/$id",
                    'rel' =>  'self',
                    'method' =>  'POST',
                    'encType' =>  'application/json'
                ]
            ]
        ];

        if (isset($request['description'])) {
            $product['description'] = $request['description'];
        }

        return $product;
    }
}
