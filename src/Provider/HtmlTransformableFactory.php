<?php

namespace AnzuSystems\AnzutapBundle\Provider;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlEmbedsAwareTransformableDocument;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformable;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableDocument;
use Doctrine\Common\Collections\ArrayCollection;

readonly class HtmlTransformableFactory
{
    public static function getTransformable(
        array $data,
        bool $lockEnabled = false,
        bool $isLocked = false,
        bool $enabledAds = false,
        bool $wideForm = false,
        RenderContext $renderContext = RenderContext::Default,
        ?string $editorName = null,
        ?ArrayCollection $embeds = null,
    ): HtmlTransformableInterface {
        return (new HtmlTransformable(
            document: null === $embeds
                ? (new HtmlTransformableDocument($data))
                : (new HtmlEmbedsAwareTransformableDocument($data, $embeds)),
            contentLockEnabled: $lockEnabled,
            locked: $isLocked,
            enabledAds: $enabledAds,
            wideForm: $wideForm,
            renderContext: $renderContext,
            editorName: $editorName
        ));
    }
}
