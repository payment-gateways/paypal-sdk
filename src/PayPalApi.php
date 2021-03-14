<?php

namespace PaymentGateway\PayPalSdk;

use EasyHttp\GuzzleLayer\GuzzleClient;
use EasyHttp\LayerContracts\Contracts\EasyClientContract;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;

abstract class PayPalApi
{
    protected EasyClientContract $client;
    protected string $baseUri;
    protected string $username;
    protected string $password;
    protected array $token;

    public function __construct(string $baseUri)
    {
        $this->baseUri = $baseUri;
        $this->client = new GuzzleClient();
    }

    public function setCredentials(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function withHandler(callable $handler)
    {
        $this->client->withHandler($handler);
    }

    protected function getToken(): array
    {
        if ($this->token ?? null) {
            return $this->token;
        }

        $client = clone $this->client;

        $client->prepareRequest('POST', $this->baseUri . '/v1/oauth2/token');
        $client->getRequest()->setBasicAuth($this->username, $this->password);
        $client->getRequest()->setQuery(['grant_type' => 'client_credentials']);

        $this->token = $client->execute()->parseJson();

        return $this->token;
    }

    protected function setAuthentication(): HttpClientRequest
    {
        return $this->client->getRequest()
            ->setHeader('Authorization', 'Bearer ' . $this->getToken()['access_token']);
    }
}
