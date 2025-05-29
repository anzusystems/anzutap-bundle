<?php

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface HtmlRendererInterface
{
    public static function getSupportedNodeNames(): array;

    public function render(AnzutapNodeInterface $node, HtmlTransformableInterface $htmlTransformable): string;
}
