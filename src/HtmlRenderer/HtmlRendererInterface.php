<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface HtmlRendererInterface
{
    public static function getSupportedNodeNames(): array;

    public function render(NodeInterface $node, DocumentRenderableInterface $documentRenderable): string;
}
