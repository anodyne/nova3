<?php

declare(strict_types=1);

use Nova\Menus\Enums\LinkTarget;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\ButtonDecoration;
use Nova\Pages\Enums\ButtonSize;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    describe('buttons', function () {
        test('can set the corner radius of the buttons', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Self->value,
                                    'size' => ButtonSize::Medium->value,
                                    'radius' => $value,
                                ],
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

        test('can set the box shadow of the buttons', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Self->value,
                                    'size' => ButtonSize::Medium->value,
                                    'shadow' => $value,
                                ],
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

        test('can set the decoration of the buttons', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Self->value,
                                    'size' => ButtonSize::Medium->value,
                                    'decoration' => $value,
                                ],
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain($expected);
        })->with(
            collect(ButtonDecoration::cases())
                ->reject(fn (ButtonDecoration $decoration): bool => $decoration === ButtonDecoration::None)
                ->flatMap(fn (ButtonDecoration $decoration): array => [[$decoration->value, $decoration->getHtml()]])
        );

        test('can set the size of the buttons', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Self,
                                    'size' => $value,
                                ],
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain($expected);
        })->with(
            collect(ButtonSize::cases())
                ->flatMap(fn (ButtonSize $decoration): array => [[$decoration->value, $decoration->getTailwindClasses()]])
        );

        test('can open a link in a new page', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Blank,
                                    'size' => ButtonSize::Medium,
                                ],
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('target="_blank"');
        });

        test('can set the background color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Self,
                                    'size' => ButtonSize::Medium,
                                    'bg-color' => 'rgba(255, 0, 0, 1)',
                                ],
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('--bg-color: rgba(255, 0, 0, 1);');
        });

        test('can set the text color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'hero.image-tiles',
                    'data' => [
                        'block' => [
                            'buttons' => [
                                [
                                    'text' => 'Button',
                                    'url' => 'https://google.com',
                                    'url-target' => LinkTarget::Self,
                                    'size' => ButtonSize::Medium,
                                    'text-color' => 'rgba(255, 0, 0, 1)',
                                ],
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('--text-color: rgba(255, 0, 0, 1);');
        });
    });
});
