<?php

namespace AnzuSystems\AnzutapBundle\Provider;

use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlEmbedsAwareTransformableDocument;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformable;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableDocument;
use Doctrine\Common\Collections\ArrayCollection;

readonly class HtmlAwareFactory
{
    public static function getTransformable(
        array $data,
        bool $lockEnabled = false,
        bool $isLocked = false,
        ?string $editorName = null,
        ?ArrayCollection $embeds = null,
    ): HtmlTransformableInterface {
        return (new HtmlTransformable())
            ->setDocument(
                null === $embeds
                    ? (new HtmlTransformableDocument())->setDocument($data)
                    : (new HtmlEmbedsAwareTransformableDocument())->setDocument($data)->setEmbeds($embeds)
            )
            ->setLocked($isLocked)
            ->setContentLockEnabled($lockEnabled)
            ->setEditorName($editorName);
    }
}
