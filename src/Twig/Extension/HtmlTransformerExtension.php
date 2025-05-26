<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Twig\Extension;

use AnzuSystems\AnzutapBundle\HtmlTransformer;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class HtmlTransformerExtension extends AbstractExtension
{
    public function __construct(
        private readonly HtmlTransformer $transformer,
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter(
                name: 'transform_html_document',
                callable: $this->transformHtmlDocument(...),
                options: ['is_safe' => ['html']],
            ),
        ];
    }

    public function transformHtmlDocument(
        HtmlTransformableInterface $documentWrapper,
        ?AdvertPool $advertPool = null,
    ): string {
        return $this->transformer->transform($documentWrapper, $advertPool);
    }
}
