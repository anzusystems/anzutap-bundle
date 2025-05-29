<?php

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface HtmlRendererInterface
{
    public static function getSupportedNodeNames(): array;

    public function render(NodeInterface $node, HtmlTransformableInterface $htmlTransformable): string;
}
