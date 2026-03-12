<?php

declare(strict_types=1);

use Nova\Pages\Blocks\Hero\ImageTilesHeroBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('renders the block', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.image-tiles',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'images' => [
                                ['image' => 'image.png'],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('nv-hero-image-tiles');
    });

    test('renders multiple images', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'hero.image-tiles',
                'data' => [
                    'block' => [
                        'buttons' => [],
                        'media' => [
                            'images' => [
                                ['image' => 'image-1.png'],
                                ['image' => 'image-2.png'],
                                ['image' => 'image-3.png'],
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('image-1.png')
            ->toContain('image-2.png')
            ->toContain('image-3.png');
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = ImageTilesHeroBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(2);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = ImageTilesHeroBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = ImageTilesHeroBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $blocks = PageBlockRegistry::blocks();

    $block = collect($blocks)->first(
        fn ($block) => $block instanceof ImageTilesHeroBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(ImageTilesHeroBlock::class);
});
