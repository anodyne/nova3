<?php

declare(strict_types=1);

use Nova\Pages\Enums\BackgroundImageIntensity;
use Nova\Pages\Enums\Blur;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\MaxWidth;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Enums\Spacing;
use Nova\Pages\Enums\TextShadow;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('content dimension settings', function () {
    test('width', function (string $width) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'width' => $width,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('max-w-'.$width);
    })->with(
        collect(MaxWidth::cases())
            ->flatMap(fn (MaxWidth $width) => [[$width->value, $width->getTailwindClasses()]])
    );

    test('horizontal spacing', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'spacing' => [
                            'horizontal' => $value,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with(
        collect(Spacing::cases())
            ->flatMap(fn ($spacing) => [[$spacing->value, $spacing->getHorizontalTailwindClasses()]])
    );

    test('vertical spacing', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'spacing' => [
                            'vertical' => $value,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with(
        collect(Spacing::cases())
            ->flatMap(fn ($spacing) => [[$spacing->value, $spacing->getVerticalTailwindClasses()]])
    );
});

describe('content appearance settings', function () {
    test('background color', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'bg' => [
                            'option' => 'color',
                            'color' => 'rgba(201, 39, 39, 1)',
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--content-bg-color: rgba(201, 39, 39, 1)');
    });

    test('predefined background image', function ($image) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'bg' => [
                            'option' => $image,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($image);
    })->with([
        'predefined light' => 'mesh-light-001',
        'predefined dark' => 'mesh-dark-004',
    ]);

    test('custom background image', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'bg' => [
                            'option' => 'custom',
                            'image' => ['test-file.jpg'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('test-file.jpg');
    });

    test('background intensity', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'bg' => [
                            'option' => 'mesh-light-000',
                            'intensity' => $value,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with(
        collect(BackgroundImageIntensity::cases())
            ->flatMap(fn (BackgroundImageIntensity $intensity): array => [[$intensity->value, $intensity->getTailwindClasses()]])
    );

    test('background blur', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'bg' => [
                            'option' => 'color',
                            'color' => 'rgba(255, 255, 255, 0.5)',
                            'blur' => $value,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with(
        collect(Blur::cases())
            ->flatMap(fn (Blur $blur): array => [[$blur->value, $blur->getTailwindClasses()]])
    );

    test('border', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'bg' => [
                            'option' => 'color',
                            'color' => 'rgba(255, 255, 255, 0.5)',
                        ],
                        'border' => [
                            'enabled' => 'yes',
                            'color' => 'rgba(0, 0, 0, 0.25)',
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--content-border-color: rgba(0, 0, 0, 0.25)');
    });

    test('shadow', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'shadow' => $value,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with(
        collect(BoxShadow::cases())
            ->flatMap(fn (BoxShadow $shadow): array => [[$shadow->value, $shadow->getTailwindClasses()]])
    );

    test('corner radius', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'radius' => $value,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with(
        collect(Radius::cases())
            ->flatMap(fn (Radius $radius): array => [[$radius->value, $radius->getTailwindClasses()]])
    );
});

describe('content header settings', function () {
    test('orientation', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'content' => [
                        'orientation' => $value,
                        'heading' => [
                            'text' => 'Header',
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain($expected);
    })->with([
        ['center', '@lg:text-center'],
        ['right', '@lg:text-right'],
    ]);

    describe('heading', function () {
        test('text and color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'content.index',
                    'data' => [
                        'content' => [
                            'heading' => [
                                'text' => 'Block Content Header',
                                'color' => 'rgba(255, 0, 0, 1)',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)
                ->toContain('Block Content Header')
                ->toContain('--content-heading-color: rgba(255, 0, 0, 1)');
        });

        test('text shadow', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'content.index',
                    'data' => [
                        'content' => [
                            'heading' => [
                                'text' => 'Block Content Header',
                                'color' => 'rgba(255, 0, 0, 1)',
                                'shadow' => $value,
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain($expected);
        })->with(
            collect(TextShadow::cases())
                ->flatMap(fn (TextShadow $shadow): array => [[$shadow->value, $shadow->getTailwindClasses()]])
        );
    });

    describe('message', function () {
        test('text and color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'content.index',
                    'data' => [
                        'content' => [
                            'message' => [
                                'text' => 'Block content message',
                                'color' => 'rgba(255, 0, 0, 1)',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)
                ->toContain('Block content message')
                ->toContain('--content-message-color: rgba(255, 0, 0, 1)');
        });

        test('text shadow', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'content.index',
                    'data' => [
                        'content' => [
                            'message' => [
                                'text' => 'Block content message',
                                'color' => 'rgba(255, 0, 0, 1)',
                                'shadow' => $value,
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain($expected);
        })->with(
            collect(TextShadow::cases())
                ->flatMap(fn (TextShadow $shadow): array => [[$shadow->value, $shadow->getTailwindClasses()]])
        );
    });

    describe('callout', function () {
        test('text', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'content.index',
                    'data' => [
                        'content' => [
                            'callout' => [
                                'text' => 'Callout text',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('Callout text');
        });

        test('text decoration', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'content.index',
                    'data' => [
                        'content' => [
                            'callout' => [
                                'text' => 'Callout text',
                                'decoration' => $value,
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain($expected);
        })->with([
            ['arrow', '→'],
            ['single-chevron', '&rsaquo;'],
            ['double-chevron', '&raquo;'],
        ]);

        describe('badge', function () {
            test('as badge', function () {
                $page = Page::factory()->basic()->published([
                    [
                        'type' => 'content.index',
                        'data' => [
                            'content' => [
                                'callout' => [
                                    'text' => 'Callout text',
                                    'type' => 'badge',
                                ],
                            ],
                        ],
                    ],
                ])->create();

                $view = view('test-page-render', ['page' => $page]);
                $html = $view->render();

                expect($html)->toContain('bg-(--content-callout-bg-color)');
            });

            test('corner radius', function ($value, $expected) {
                $page = Page::factory()->basic()->published([
                    [
                        'type' => 'content.index',
                        'data' => [
                            'content' => [
                                'callout' => [
                                    'text' => 'Callout text',
                                    'type' => 'badge',
                                    'radius' => $value,
                                ],
                            ],
                        ],
                    ],
                ])->create();

                $view = view('test-page-render', ['page' => $page]);
                $html = $view->render();

                expect($html)->toContain($expected);
            })->with(
                collect(Radius::cases())
                    ->flatMap(fn (Radius $radius): array => [[$radius->value, $radius->getTailwindClasses()]])
            );

            test('shadow', function ($value, $expected) {
                $page = Page::factory()->basic()->published([
                    [
                        'type' => 'content.index',
                        'data' => [
                            'content' => [
                                'callout' => [
                                    'text' => 'Callout text',
                                    'type' => 'badge',
                                    'shadow' => $value,
                                ],
                            ],
                        ],
                    ],
                ])->create();

                $view = view('test-page-render', ['page' => $page]);
                $html = $view->render();

                expect($html)->toContain($expected);
            })->with(
                collect(BoxShadow::cases())
                    ->flatMap(fn (BoxShadow $shadow): array => [[$shadow->value, $shadow->getTailwindClasses()]])
            );

            test('background color', function () {
                $page = Page::factory()->basic()->published([
                    [
                        'type' => 'content.index',
                        'data' => [
                            'content' => [
                                'callout' => [
                                    'text' => 'Callout text',
                                    'type' => 'badge',
                                    'bg' => [
                                        'color' => 'rgba(0, 255, 0, 0.25)',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])->create();

                $view = view('test-page-render', ['page' => $page]);
                $html = $view->render();

                expect($html)->toContain('--content-callout-bg-color: rgba(0, 255, 0, 0.25)');
            });

            test('text color', function () {
                $page = Page::factory()->basic()->published([
                    [
                        'type' => 'content.index',
                        'data' => [
                            'content' => [
                                'callout' => [
                                    'text' => 'Callout text',
                                    'type' => 'badge',
                                    'color' => 'rgba(0, 155, 0, 1)',
                                ],
                            ],
                        ],
                    ],
                ])->create();

                $view = view('test-page-render', ['page' => $page]);
                $html = $view->render();

                expect($html)->toContain('--content-callout-text-color: rgba(0, 155, 0, 1)');
            });

            test('border color', function () {
                $page = Page::factory()->basic()->published([
                    [
                        'type' => 'content.index',
                        'data' => [
                            'content' => [
                                'callout' => [
                                    'text' => 'Callout text',
                                    'type' => 'badge',
                                    'border' => [
                                        'color' => 'rgba(0, 155, 0, 0.35)',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])->create();

                $view = view('test-page-render', ['page' => $page]);
                $html = $view->render();

                expect($html)->toContain('--content-callout-border-color: rgba(0, 155, 0, 0.35)');
            });
        });
    });
});
