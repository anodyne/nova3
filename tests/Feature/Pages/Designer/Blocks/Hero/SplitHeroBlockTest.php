<?php

declare(strict_types=1);

use Nova\Pages\Blocks\Hero\SplitHeroBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\MediaType;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('renders the block', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.split',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'type' => MediaType::Image,
                            'image' => 'image.png',
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('nv-hero-split');
    });

    test('can render the image to the left of the content', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.split',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'type' => MediaType::Image,
                            'orientation' => 'left',
                            'image' => 'image.png',
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('order-first justify-end');
    });

    test('can render the image to the right of the content', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.split',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'type' => MediaType::Image,
                            'orientation' => 'right',
                            'image' => 'image.png',
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('order-last');
    });

    test('can set the corner radius of the media', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.split',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'type' => MediaType::Image,
                            'image' => 'image.png',
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

    test('can set the shadow of the media', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.split',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'type' => MediaType::Image,
                            'image' => 'image.png',
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

    test('does not render media when it is disabled', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.split',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'type' => MediaType::None,
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->not->toContain('nv-hero-image-ctn');
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = SplitHeroBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(2);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = SplitHeroBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = SplitHeroBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $blocks = PageBlockRegistry::blocks();

    $block = collect($blocks)->first(
        fn ($block) => $block instanceof SplitHeroBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(SplitHeroBlock::class);
});
