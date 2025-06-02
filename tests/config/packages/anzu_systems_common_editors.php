<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\Model\EditorsConfiguration;
use AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer\AdHtmlRenderer;
use AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer\ContentLockHtmlRenderer;
use Symfony\Config\AnzuSystemsAnzutapConfig;

return static function (AnzuSystemsAnzutapConfig $config): void {
    $config->defaultEditorName('test');

    $config
        ->editors('test')
        ->allowedHtmlRenderers([
            ...EditorsConfiguration::DEFAULT_ALLOWED_EDITOR_HTML_RENDERERS,
            AdHtmlRenderer::class,
            ContentLockHtmlRenderer::class,
        ])
    ;
};
