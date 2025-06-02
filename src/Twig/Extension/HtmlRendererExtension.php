<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Twig\Extension;

use AnzuSystems\AnzutapBundle\Factory\DocumentRenderableFactory;
use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRenderer;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderContext;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class HtmlRendererExtension extends AbstractExtension
{
    public function __construct(
        private readonly HtmlRenderer $renderer,
        private readonly DocumentRenderableFactory $documentRenderableFactory,
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
            new TwigFilter(
                name: 'render_json_data',
                callable: $this->renderJsonData(...),
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

    public function renderJsonData(
        array $data,
        ?DocumentRenderContext $context = null,
    ): string {
        return $this->renderer->render(
            $this->documentRenderableFactory->createRenderable(
                DocumentRenderableFactory::createBodyAware($data),
                $context ?? new DocumentRenderContext(),
            )
        );
    }
}
