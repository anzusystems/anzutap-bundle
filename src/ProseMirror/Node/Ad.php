<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\CustomRenderNodeInterface;
use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\TransformableDocumentWrapperInterface;
use Twig\Environment;
use Twig\Error\Error;

final class Ad extends AbstractNode
{
    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public static function getNodeType(): string
    {
        return 'ad';
    }

//    /**
//     * @throws Error
//     */
//    public function render(array $node, TransformableDocumentWrapperInterface $transformableDocument): string
//    {
//        return $this->twig->render('@AnzuCommonWeb/common/sme-advert-manager/slot.html.twig', [
//            'position' => $node['attrs']['position'],
//        ]);
//    }

    public function tag(array $node): array
    {
        return [];
    }
}
