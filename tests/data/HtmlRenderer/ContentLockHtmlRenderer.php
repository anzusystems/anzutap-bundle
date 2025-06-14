<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer;

use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRendererInterface;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use Twig\Error\Error;

final readonly class ContentLockHtmlRenderer implements HtmlRendererInterface
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'contentLock',
        ];
    }

    /**
     * @throws Error
     */
    public function render(NodeInterface $node, DocumentRenderableInterface $documentRenderable): string
    {
        if ($documentRenderable->getContext()->isContentLockEnabled() && false === $documentRenderable->getContext()->isUnlocked()) {
            return '<div>LOCKED</div>';
        }

        return '';
    }
}
