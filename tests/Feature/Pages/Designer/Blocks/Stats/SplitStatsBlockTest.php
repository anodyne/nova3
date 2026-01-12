<?php

declare(strict_types=1);

use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Blocks\Stats\SplitStatsBlock;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('can show 1 stat', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stats.split',
                'data' => [
                    'block' => [
                        'stats' => [
                            ['stat' => 'all-time-posts', 'heading' => 'All-time posts'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-stats-split')
            ->toContain('All-time posts');
    });

    test('can show 2 stats', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stats.split',
                'data' => [
                    'block' => [
                        'stats' => [
                            ['stat' => 'all-time-posts', 'heading' => 'All-time posts'],
                            ['stat' => 'all-time-post-words', 'heading' => 'All-time post words'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-stats-split')
            ->toContain('All-time posts')
            ->toContain('All-time post words');
    });

    test('can show 3 stats', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stats.split',
                'data' => [
                    'block' => [
                        'stats' => [
                            ['stat' => 'all-time-posts', 'heading' => 'All-time posts'],
                            ['stat' => 'all-time-post-words', 'heading' => 'All-time post words'],
                            ['stat' => 'current-month-posts', 'heading' => 'Posts this month'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-stats-split')
            ->toContain('All-time posts')
            ->toContain('All-time post words')
            ->toContain('Posts this month');
    });

    test('can show 4 stats', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stats.split',
                'data' => [
                    'block' => [
                        'stats' => [
                            ['stat' => 'all-time-posts', 'heading' => 'All-time posts'],
                            ['stat' => 'all-time-post-words', 'heading' => 'All-time post words'],
                            ['stat' => 'current-month-posts', 'heading' => 'Posts this month'],
                            ['stat' => 'current-month-post-words', 'heading' => 'Post words this month'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-stats-split')
            ->toContain('All-time posts')
            ->toContain('All-time post words')
            ->toContain('Posts this month')
            ->toContain('Post words this month');
    });

    test('can change the text colors', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stats.split',
                'data' => [
                    'block' => [
                        'appearance' => [
                            'stat-color' => 'rgba(100, 100, 100, 1)',
                            'label-color' => 'rgba(200, 200, 200, 1)',
                        ],
                        'stats' => [
                            ['stat' => 'all-time-posts', 'heading' => 'All-time posts'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('--stat-stat-color: rgba(100, 100, 100, 1)')
            ->toContain('--stat-label-color: rgba(200, 200, 200, 1)');
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = SplitStatsBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(2);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = SplitStatsBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = SplitStatsBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $block = collect(PageBlockRegistry::blocks())->first(
        fn ($block) => $block instanceof SplitStatsBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(SplitStatsBlock::class);
});
