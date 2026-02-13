<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\Model\EditorsConfiguration;
use AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer\AdHtmlRenderer;
use AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer\ContentLockHtmlRenderer;

return App::config([
    'anzu_systems_anzutap' => [
        'default_editor_name' => 'test',
        'editors' => [
            'test' => [
                'allowed_html_renderers' => [
                    ...EditorsConfiguration::DEFAULT_ALLOWED_EDITOR_HTML_RENDERERS,
                    AdHtmlRenderer::class,
                    ContentLockHtmlRenderer::class,
                ],
            ],
        ],
    ],
]);
