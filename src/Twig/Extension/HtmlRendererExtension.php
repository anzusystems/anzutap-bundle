<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Twig\Extension;

use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRenderer;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
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
        DocumentRenderableInterface $renderable,
        ?AdvertPool $advertPool = null,
    ): string {
        return $this->renderer->render($renderable, $advertPool);
    }
}
