<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests\Anzutap;

use AnzuSystems\AnzutapBundle\Editor\AnzutapEditor;
use AnzuSystems\AnzutapBundle\Tests\AnzuKernelTestCase;

final class AnzutapTransformerTest extends AnzuKernelTestCase
{
    private AnzutapEditor $editor;

    protected function setUp(): void
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
                'html' => '<h2><h2>what <i>is</i> that</h2></h2>',
                'anzuTap' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'heading',
                            'attrs' => [
                                'level' => 3,
                            ],
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'what ',
                                ],
                                [
                                    'type' => 'text',
                                    'text' => 'is',
                                    'marks' => [
                                        ['type' => 'italic'],
                                    ],
                                ],
                                [
                                    'type' => 'text',
                                    'text' => ' that',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'html' => '<ul><li>coze</li><li><hr></li></ul>',
                'anzuTap' => [
                    'type' => 'doc',
                    'content' => [
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
                                                    'text' => 'coze',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'horizontalRule',
                        ],
                    ],
                ],
            ],
            [
                'html' => '<b><p>Joseph</p></b>',
                'anzuTap' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'paragraph',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Joseph',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'html' => '<p><url href="#1">Anchor link</url><anchor name="1"></anchor></p>',
                'anzuTap' => ['type' => 'doc', 'content' => [
                    [
                        'type' => 'paragraph',
                        'attrs' => [
                            'anchor' => 'pp-1',
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
                                'text' => 'Anchor link',
                            ],
                        ],
                    ],
                ]],
            ],
            [
                'html' => '<p><ul></ul></p>',
                'anzuTap' => ['type' => 'doc', 'content' => [
                    [
                        'type' => 'paragraph',
                    ],
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
                                                'text' => 'Item',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]],
            ],
        ];
    }
}
