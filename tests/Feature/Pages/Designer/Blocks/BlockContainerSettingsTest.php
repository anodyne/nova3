<?php

declare(strict_types=1);

use Nova\Pages\Enums\BackgroundImageIntensity;
use Nova\Pages\Enums\MaxWidth;
use Nova\Pages\Enums\Spacing;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('container dimension settings', function () {
    test('width', function (string $width) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'container' => [
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
                    'container' => [
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
                    'container' => [
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

describe('container appearance settings', function () {
    test('background color', function ($color) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'container' => [
                        'bg' => [
                            'option' => 'color',
                            'color' => $color,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('style="--container-bg-color: '.$color);
    })->with([
        'color' => 'rgba(201, 39, 39, 1)',
        'transparent' => 'transparent',
    ]);

    test('predefined background image', function ($image) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'container' => [
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
                    'container' => [
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
                    'container' => [
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
});
