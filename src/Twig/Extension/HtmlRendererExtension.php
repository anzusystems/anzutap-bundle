<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Twig\Extension;

use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRenderer;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class HtmlRendererExtension extends AbstractExtension
{
    public function __construct(
        private readonly HtmlRenderer $renderer,
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter(
                name: 'render_html_document',
                callable: $this->renderHtmlDocument(...),
                options: ['is_safe' => ['html']],
            ),
        ];
    }

    public function renderHtmlDocument(
        NodeInterface $node,
        HtmlTransformableInterface $documentWrapper,
        ?AdvertPool $advertPool = null,
    ): string {
        return $this->renderer->render($node, $documentWrapper, $advertPool);
    }
}
