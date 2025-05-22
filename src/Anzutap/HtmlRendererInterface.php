<?php

namespace AnzuSystems\AnzutapBundle\Anzutap;

use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface HtmlRendererInterface
{
    public static function getSupportedNodeNames(): array;

    public function render(AnzutapNodeInterface $node, HtmlTransformableInterface $htmlTransformable): string;
}
