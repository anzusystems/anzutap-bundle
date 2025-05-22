<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Configuration;

use;
use;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark\AnzuMarkTransformerInterface;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\AnzuNodeTransformerInterface;

interface AnzutapConfigurationInterface
{
    /**
     * @return array<class-string<AnzuNodeTransformerInterface>>
     */
    public function getAllowedNodeTransformers(): array;

    /**
     * @return array<class-string<AnzuMarkTransformerInterface>>
     */
    public function getAllowedMarkTransformers(): array;

    public function getPreprocessorFormat(): ?string;

    /**
     * @return array<int, string>
     */
    public function getRemove(): array;

    /**
     * @return array<int, string>
     */
    public function getSkip(): array;

    /**
     * @return class-string<AnzuNodeTransformerInterface>
     */
    public function getDefaultTransformer(): string;
}
