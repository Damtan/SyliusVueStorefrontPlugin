<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Property\Builder\Product;

use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Property\Builder\AbstractBuilder;
use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Property\NameResolver\PrefixedNameResolverInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Event\TransformEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;

final class NamePropertyBuilder extends AbstractBuilder
{
    /**
     * @var PrefixedNameResolverInterface
     */
    private $productNameNameResolver;

    /**
     * @param PrefixedNameResolverInterface $productNameNameResolver
     */
    public function __construct(PrefixedNameResolverInterface $productNameNameResolver)
    {
        $this->productNameNameResolver = $productNameNameResolver;
    }

    public function consumeEvent(TransformEvent $event): void
    {
        $this->buildProperty(
            $event,
            ProductInterface::class,
            function (ProductInterface $product, Document $document): void {
                /** @var ProductTranslationInterface $productTranslation */
                foreach ($product->getTranslations() as $productTranslation) {
                    $propertyName = $this->productNameNameResolver->resolvePropertyName($productTranslation->getLocale());

                    $document->set($propertyName, $productTranslation->getName());
                }
            }
        );
    }
}