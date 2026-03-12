<?php

declare(strict_types=1);

use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Blocks\Stories\StoriesTimelineBlock;
use Nova\Pages\Models\Page;
use Nova\PublicSite\Livewire\StoriesTimeline;
use Nova\Stories\Models\Story;

use function Pest\Livewire\livewire;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('renders block', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.timeline',
                'data' => [
                    'block' => [
                        'timelineSorting' => 'asc',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-stories-timeline');
    });
});

describe('livewire component', function () {
    test('can sort by timeline direction', function (string $sorting, string $direction) {
        $story1 = Story::factory()->completed()->create(['order_column' => 1]);
        $story2 = Story::factory()->completed()->create(['order_column' => 2]);

        $component = livewire(StoriesTimeline::class, ['sortDirection' => $sorting]);
        $stories = $component->instance()->stories;

        $firstStory = $direction == 'ascending' ? $story1 : $story2;
        $lastStory = $direction == 'ascending' ? $story2 : $story1;

        expect($stories->first()->id)->toBe($firstStory->id)
            ->and($stories->last()->id)->toBe($lastStory->id);
    })->with([
        'ascending' => ['asc', 'ascending'],
        'descending' => ['desc', 'descending'],
    ]);
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = StoriesTimelineBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(1);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = StoriesTimelineBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = StoriesTimelineBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $block = collect(PageBlockRegistry::blocks())->first(
        fn ($block) => $block instanceof StoriesTimelineBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(StoriesTimelineBlock::class);
});
