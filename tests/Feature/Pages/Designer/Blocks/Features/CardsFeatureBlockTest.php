<?php

declare(strict_types=1);

use Nova\Pages\Blocks\Features\CardsFeatureBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('renders the block', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);

        $html = $view->render();

        expect($html)
            ->toContain('nv-features-cards')
            ->toContain('Card title')
            ->toContain('Card description')
            ->toContain('card-image.png');
    });

    test('can set the corner radius of the cards', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'card' => [
                            'radius' => $value,
                        ],
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
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

    test('can set the box shadow of the cards', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'card' => [
                            'shadow' => $value,
                        ],
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
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

    test('can set the card heading text color', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'heading-color' => 'rgba(100, 100, 100, 1)',
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--feature-heading-color: rgba(100, 100, 100, 1);');
    });

    test('can set the card description text color', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'description-color' => 'rgba(100, 100, 100, 1)',
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--feature-description-color: rgba(100, 100, 100, 1);');
    });

    test('can set the card background color', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'card' => [
                            'bg' => 'rgba(250, 250, 250, 1)',
                        ],
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--feature-card-color: rgba(250, 250, 250, 1);');
    });

    test('can have a border around the cards', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'card' => [
                            'border' => [
                                'enabled' => 'yes',
                                'color' => 'rgba(200, 200, 200, 1)',
                            ],
                        ],
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--feature-card-border-color: rgba(200, 200, 200, 1);');
    });

    test('can orient the image at the top of the card', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'card' => [
                            'image-orientation' => 'top',
                        ],
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('order-first mt-1');
    });

    test('can orient the image at the bottom of the card', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'card' => [
                            'image-orientation' => 'bottom',
                        ],
                        'rows' => [
                            [
                                'layout' => 'sm-md',
                                'columns' => [
                                    ['heading' => 'Card title', 'description' => 'Card description', 'image' => 'card-image.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('mb-1')
            ->and($html)->not->toContain('order-first mt-1');
    });

    test('applies column spans based on the row layout', function (string $layout, array $expected, array $unexpected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'features.cards',
                'data' => [
                    'block' => [
                        'rows' => [
                            [
                                'layout' => $layout,
                                'columns' => [
                                    ['heading' => 'Card A', 'description' => 'Card A description', 'image' => 'card-a.png'],
                                    ['heading' => 'Card B', 'description' => 'Card B description', 'image' => 'card-b.png'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        foreach ($expected as $class) {
            expect($html)->toContain($class);
        }

        foreach ($unexpected as $class) {
            expect($html)->not->toContain($class);
        }
    })->with([
        'md-sm' => ['md-sm', ['col-span-2', 'col-span-1'], ['col-span-3']],
        'sm-md' => ['sm-md', ['col-span-1', 'col-span-2'], ['col-span-3']],
        'sm' => ['sm', ['col-span-1'], ['col-span-2', 'col-span-3']],
        'lg' => ['lg', ['col-span-3'], ['col-span-2', 'col-span-1']],
    ]);
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = CardsFeatureBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(2);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = CardsFeatureBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = CardsFeatureBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $blocks = PageBlockRegistry::blocks();

    $block = collect($blocks)->first(
        fn ($block) => $block instanceof CardsFeatureBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(CardsFeatureBlock::class);
});
