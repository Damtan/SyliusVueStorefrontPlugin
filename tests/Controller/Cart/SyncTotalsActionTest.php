<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class SyncTotalsActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_synchronizing_totals(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml', 'order.yaml', 'coupon_based_promotion.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/totals?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $this->request(Request::METHOD_GET, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/sync_totals_successful');
    }

    public function test_synchronizing_totals_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml', 'order.yaml', 'coupon_based_promotion.yaml']);

        $uri = sprintf(
            '/vsbridge/cart/totals?token=%s&cartId=%s',
            12345,
            12345
        );

        $this->request(Request::METHOD_GET, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_token', Response::HTTP_UNAUTHORIZED);
    }

    public function test_synchronizing_totals_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml', 'order.yaml', 'coupon_based_promotion.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/totals?token=%s&cartId=%s',
            $this->token,
            123
        );

        $this->request(Request::METHOD_GET, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_cart', Response::HTTP_BAD_REQUEST);
    }
}
