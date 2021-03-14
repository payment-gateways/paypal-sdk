<?php

namespace PaymentGateway\PayPalSdk\Tests\Api\Concerns;

use EasyHttp\MockBuilder\MockBuilder;

trait HasMockBuilder
{
    protected string $username = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
    protected string $password = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';

    protected MockBuilder $builder;

    protected function createBuilder()
    {
        $builder = new MockBuilder();

        $builder
            ->when()
                ->headerIs('Authorization', 'Basic ' . base64_encode("{$this->username}:{$this->password}"))
                ->methodIs('POST')
                ->pathIs('/v1/oauth2/token')
            ->then()
                ->body('{ "access_token": "dG9rZW4=" }');

        $this->builder = $builder;
    }
}
