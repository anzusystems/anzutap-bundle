<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer;

use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRendererInterface;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use Twig\Error\Error;

final readonly class AdHtmlRenderer implements HtmlRendererInterface
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'ad',
        ];
    }

    /**
     * @throws Error
     */
    public function render(NodeInterface $node, DocumentRenderableInterface $documentRenderable): string
    {
        return '<div class="ad-position">' . ($node->getAttrs()['position'] ?? '0') . '</div>';
    }
}
