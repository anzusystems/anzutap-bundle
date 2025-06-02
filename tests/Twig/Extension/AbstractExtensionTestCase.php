<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests\Twig\Extension;

use AnzuSystems\AnzutapBundle\Factory\DocumentRenderableFactory;
use AnzuSystems\AnzutapBundle\Tests\AnzuKernelTestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

abstract class AbstractExtensionTestCase extends AnzuKernelTestCase
{
    protected Environment $twig;
    protected RequestStack $requestStack;
    protected DocumentRenderableFactory $renderableFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twig = $this->getService(Environment::class);
        $this->requestStack = $this->getService(RequestStack::class);
        $this->renderableFactory = $this->getService(DocumentRenderableFactory::class);
    }
}
