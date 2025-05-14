<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests\Traits;

use AnzuSystems\AnzutapBundle\Kernel\AnzutapKernel;

trait AnzuKernelTrait
{
    /**
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @template T
     *
     * @param class-string<T>|string $service
     *
     * @return T|object
     */
    public function getService(string $service): object
    {
        return self::getContainer()->get($service);
    }

    /**
     * @psalm-suppress UnsafeInstantiation
     */
    protected static function createKernel(array $options = []): AnzutapKernel
    {
        /** @var class-string<AnzutapKernel> $kernelClass */
        $kernelClass = static::getKernelClass();

        return new $kernelClass(
            appSystem: (string) self::resolveKernelOption($options, 'system', 'APP_SYSTEM', ''),
            appVersion: (string) self::resolveKernelOption($options, 'version', 'APP_VERSION', '0.0.0'),
            appTimeZone: (string) self::resolveKernelOption($options, 'version', 'APP_TIMEZONE', 'Europe/Bratislava'),
            environment: (string) self::resolveKernelOption($options, 'environment', 'APP_ENV', 'test'),
            debug: (bool) self::resolveKernelOption($options, 'debug', 'APP_DEBUG', true),
        );
    }

    private static function resolveKernelOption(
        array $options,
        string $optionName,
        string $envName,
        mixed $default
    ): mixed {
        return $options[$optionName] ?? $_ENV[$envName] ?? $_SERVER[$envName] ?? $default;
    }
}
