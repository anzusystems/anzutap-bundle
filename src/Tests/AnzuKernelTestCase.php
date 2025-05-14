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
}
