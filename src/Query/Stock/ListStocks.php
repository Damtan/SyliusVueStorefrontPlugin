<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Query\Stock;

use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;

class ListStocks implements QueryInterface
{
    /** string */
    protected $skus;

    public function __construct(string $skus)
    {
        $this->skus = $skus;
    }

    public function SKUsToArray(): array
    {
        return \explode(',', $this->skus);
    }
}
