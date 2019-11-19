<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use Symfony\Component\HttpFoundation\Request;

final class UpdateCartRequest
{
    /** @var string|null */
    private $token;

    /** @var int|string */
    private $cartId;

    /** @var array|null */
    private $cartItem;

    public function __construct(Request $request)
    {
        $this->token = $request->query->get('token');
        $this->cartId = $request->query->get('cartId');
        $this->cartItem = $request->request->get('cartItem');
    }

    public function getCommand(): UpdateCart
    {
        return new UpdateCart($this->token, $this->cartId, $this->cartItem);
    }
}