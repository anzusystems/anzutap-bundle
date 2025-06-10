<?php

namespace AnzuSystems\AnzutapBundle\Tests\Anzutap;


use AnzuSystems\AnzutapBundle\Editor\AnzutapEditor;
use AnzuSystems\AnzutapBundle\Tests\AnzuKernelTestCase;

final class AnzutapTransformerTest extends AnzuKernelTestCase
{
    private AnzuTapEditor $editor;

    public function setUp(): void
    {
        $this->editor = static::getContainer()->get('anzu_systems_anzutap.editor.test');
    }

    /**
     * @dataProvider transformerDataProvider
     */
    public function testTransformer(string $html, array $anzuTap): void
    {
        $body = $this->editor->transform($html);
        $this->assertEqualsCanonicalizing($anzuTap, $body->getAnzutapBody()->toArray());
    }

    public function transformerDataProvider(): array
    {
        return [
            [
                'html' => '<p><url href="#1">Anchor link</url><anchor name="1"></anchor></p>',
                'anzuTap' => ['type' => 'doc', 'content' => [
                    [
                        'type' => 'paragraph',
                        'attrs' => [
                            'anchor' => 'pp-1'
                        ],
                        'content' => [
                            ['type' => 'text', 'marks' => [
                                ['type' => 'link', 'attrs' => [
                                    'variant' => 'anchor',
                                    'href' => 'pp-1',
                                    'nofollow' => false,
                                    'external' => false,
                                ]],
                            ],
                                'text' => 'Anchor link'
                            ],
                        ]
                    ]
                ]],
            ],
            [
                'html' => '<p><ul></ul></p>',
                'anzuTap' => ['type' => 'doc', 'content' => [
                    [
                        'type' => 'paragraph',
                    ]
                ]],
            ],
            [
                'html' => '<p><ul><li>Item</li></ul></p>',
                'anzuTap' => ['type' => 'doc', 'content' => [
                    [
                        'type' => 'paragraph',
                    ],
                    [
                        'type' => 'bulletList',
                        'content' => [
                            [
                                'type' => 'listItem',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'content' => [
                                            [
                                                'type' => 'text',
                                                'text' => 'Item'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]],
            ],
        ];
    }
}
