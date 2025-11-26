<?php

declare(strict_types=1);

use Nova\Pages\Blocks\ContentRatings\GridContentRatingsBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('displays the content in light mode', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content-ratings.grid',
                'data' => [
                    'block' => [
                        'dark' => false,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-ratings-grid')
            ->toContain('nv-ratings-grid-item-1-light');
    });

    test('displays the content in dark mode', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content-ratings.grid',
                'data' => [
                    'block' => [
                        'dark' => true,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-ratings-grid')
            ->toContain('nv-ratings-grid-item-1-dark');
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = GridContentRatingsBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(1);

        expect($blockSchema[0])->toBeInstanceOf(\Filament\Forms\Components\Toggle::class);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = GridContentRatingsBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = GridContentRatingsBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $blocks = PageBlockRegistry::blocks();

    $gridContentRatingsBlock = collect($blocks)->first(
        fn ($block) => $block instanceof GridContentRatingsBlock
    );

    expect($gridContentRatingsBlock)->not->toBeNull()
        ->and($gridContentRatingsBlock)->toBeInstanceOf(GridContentRatingsBlock::class);
});
