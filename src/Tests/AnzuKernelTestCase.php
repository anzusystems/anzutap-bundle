<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests;

use AnzuSystems\AnzutapBundle\Tests\Traits\AnzuKernelTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnzuKernelTestCase extends KernelTestCase
{
    use AnzuKernelTrait;

    public static function setUpBeforeClass(): void
    {
        static::bootKernel();
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $service
     *
     * @return T
     */
    public function getService(string $service): object
    {
        return self::getContainer()->get($service);
    }
}
