<?php

declare(strict_types=1);

use Nova\Pages\Blocks\Content\FreeformContentBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('displays the content', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'content.index',
                'data' => [
                    'block' => [
                        'content' => "<p>Sunt adipisicing deserunt irure. Minim est exercitation magna exercitation eu nisi eiusmod aliquip ullamco ex aliquip pariatur do qui consectetur. Veniam ex velit deserunt aliqua ut ut laboris Lorem ipsum sit officia dolor veniam duis. Est eiusmod in officia do incididunt officia officia fugiat exercitation qui.<\/p>",
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('Sunt adipisicing deserunt irure')
            ->toContain('nv-content');
    });
});

describe('schema structure', function () {
    test('content field is a RichEditor component', function () {
        $block = FreeformContentBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema[1])->toBeInstanceOf(\Filament\Forms\Components\RichEditor::class)
            ->and($blockSchema[1]->getName())->toBe('block.content')
            ->and($blockSchema[1]->getLabel())->toBe('Content');
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = FreeformContentBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = FreeformContentBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $blocks = PageBlockRegistry::blocks();

    $contentBlock = collect($blocks)->first(
        fn ($block) => $block instanceof FreeformContentBlock
    );

    expect($contentBlock)->not->toBeNull()
        ->and($contentBlock)->toBeInstanceOf(FreeformContentBlock::class);
});
