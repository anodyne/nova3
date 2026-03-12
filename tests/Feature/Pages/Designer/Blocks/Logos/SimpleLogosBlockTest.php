<?php

declare(strict_types=1);

use Nova\Pages\Blocks\Logos\SimpleLogosBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('can show a logo', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'logos.simple',
                'data' => [
                    'block' => [
                        'logos' => [
                            ['url' => 'https://google.com', 'text' => 'Logo text', 'image' => 'logo1.png'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-logos-simple')
            ->toContain('Logo text')
            ->toContain('text-(--logo-text-color)')
            ->toContain('https://google.com')
            ->toContain('logo1.png');
    });

    test('does not show logo text if it is not provided', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'logos.simple',
                'data' => [
                    'block' => [
                        'logos' => [
                            ['url' => 'https://google.com', 'text' => null, 'image' => 'logo1.png'],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-logos-simple')
            ->toContain('https://google.com')
            ->toContain('logo1.png')
            ->not->toContain('Logo text')
            ->not->toContain('text-(--logo-text-color)');
    });

    test('can change the text colors', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'logos.simple',
                'data' => [
                    'block' => [
                        'logos' => [
                            [
                                'url' => 'https://google.com',
                                'text' => 'Logo text',
                                'text-color' => 'rgba(200, 200, 200, 1)',
                                'image' => 'logo1.png',
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('--logo-text-color: rgba(200, 200, 200, 1)');
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = SimpleLogosBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(1);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = SimpleLogosBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = SimpleLogosBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $block = collect(PageBlockRegistry::blocks())->first(
        fn ($block) => $block instanceof SimpleLogosBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(SimpleLogosBlock::class);
});
