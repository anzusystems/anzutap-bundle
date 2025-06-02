<?php

namespace AnzuSystems\AnzutapBundle\Tests\Twig\Extension;

use AnzuSystems\AnzutapBundle\Factory\DocumentRenderableFactory;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPlacement;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderContext;
use Symfony\Component\Finder\Finder;

class HtmlRendererExtensionTest extends AbstractExtensionTestCase
{
    private const array CONTENT_LOCK_ENABLED_DOCUMENTS = [
        'document_locked',
        'document_unlocked',
    ];
    private const array WIDE_FORM_ENABLED_DOCUMENTS = [
        'document_locked',
        'document_unlocked',
    ];
    private const array CONTENT_LOCK_LOCKED_DOCUMENTS = [
        'document_locked',
    ];

    /**
     * @dataProvider renderHtmlDocumentDataProvider
     */
    public function testRenderHtmlDocument(
        array $data,
        string $exceptedHtml,
        DocumentRenderContext $context,
        AdvertPool $advertPool,
    ): void
    {
        $template = $this->twig->createTemplate('{{ document|render_html_document(advertPool) }}');

        $rendered = $template->render([
            'document' => $this->renderableFactory->createRenderable(
                DocumentRenderableFactory::createBodyAware($data),
                $context,
            ),
            'advertPool' => $advertPool,
        ]);
        $this->assertSame($exceptedHtml, $rendered);
    }

    public static function renderHtmlDocumentDataProvider(): array
    {
        $files = [];
        $finder = new Finder();
        $finder->in(__DIR__ . '/../../data/_body/renderer');
        foreach ($finder as $file) {
            if ('json' === $file->getExtension()) {
                $files[$file->getFilenameWithoutExtension()][0] ??= json_decode($file->getContents(), true);
            }
            if ('html' === $file->getExtension()) {
                $files[$file->getFilenameWithoutExtension()][1] ??= trim($file->getContents());
            }
            $files[$file->getFilenameWithoutExtension()][2] = new DocumentRenderContext(
                contentLockEnabled: in_array($file->getFilenameWithoutExtension(), self::CONTENT_LOCK_ENABLED_DOCUMENTS, true),
                unlocked: false === in_array($file->getFilenameWithoutExtension(), self::CONTENT_LOCK_LOCKED_DOCUMENTS, true),
                enabledAds: true,
                wideForm: in_array($file->getFilenameWithoutExtension(), self::WIDE_FORM_ENABLED_DOCUMENTS, true),
            );
            $files[$file->getFilenameWithoutExtension()][3] = (new AdvertPool([
                new AdvertPlacement('mega_advert', 0, allowPlaceAdEnding: true, forcePlacement: true),
                new AdvertPlacement('mini_advert', 500, 1),
                new AdvertPlacement('mini_advert', 600, 2),
            ]))
            ;

            ksort($files[$file->getFilenameWithoutExtension()]);
        }

        return $files;
    }
}
