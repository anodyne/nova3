<?php

declare(strict_types=1);

use Nova\Pages\Blocks\Features\AlternatingFeatureBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('renders the block', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.alternating',
                'data' => [
                    'block' => [
                        'features' => [
                            ['content' => 'Content', 'image' => ['feature-image.png']],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);

        $html = $view->render();

        expect($html)
            ->toContain('nv-features-alternating')
            ->toContain('nv-feature-image');
    });

    test('can set the corner radius of the images', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.alternating',
                'data' => [
                    'block' => [
                        'image' => [
                            'radius' => $value,
                        ],
                        'features' => [
                            ['content' => 'Content', 'image' => ['feature-image.png']],
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

    test('can set the box shadow of the images', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.alternating',
                'data' => [
                    'block' => [
                        'image' => [
                            'shadow' => $value,
                        ],
                        'features' => [
                            ['content' => 'Content', 'image' => ['feature-image.png']],
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

    test('can render content on a light background', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.alternating',
                'data' => [
                    'block' => [
                        'features' => [
                            ['content' => 'Content', 'image' => ['feature-image.png']],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->not->toContain('prose-invert');
    });

    test('can render content on a dark background', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.alternating',
                'data' => [
                    'block' => [
                        'features' => [
                            ['content' => 'Content', 'image' => ['feature-image.png']],
                        ],
                        'dark' => true,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('prose-invert');
    });

    test('alternates feature order for even items', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.alternating',
                'data' => [
                    'block' => [
                        'features' => [
                            ['content' => 'First content', 'image' => ['feature-1.png']],
                            ['content' => 'Second content', 'image' => ['feature-2.png']],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect(substr_count($html, 'order-last'))->toBe(1)
            ->and(substr_count($html, 'order-first'))->toBe(1);
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = AlternatingFeatureBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(1);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = AlternatingFeatureBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = AlternatingFeatureBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $blocks = PageBlockRegistry::blocks();

    $block = collect($blocks)->first(
        fn ($block) => $block instanceof AlternatingFeatureBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(AlternatingFeatureBlock::class);
});
