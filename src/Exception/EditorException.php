<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Exception;

use Exception;

final class EditorException extends Exception
{
    private const string NOT_FOUND = 'editor_not_found';

    public function __construct(
        string $message = self::NOT_FOUND,
        private readonly string $detail = ''
    ) {
        parent::__construct(message: $message);
    }

    public function getDetail(): string
    {
        return $this->detail;
    }
}
