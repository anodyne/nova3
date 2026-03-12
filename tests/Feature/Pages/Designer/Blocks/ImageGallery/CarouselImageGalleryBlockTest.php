<?php

declare(strict_types=1);

use Nova\Pages\Blocks\ImageGallery\CarouselImageGalleryBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('can show an image', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-image-gallery-carousel')
            ->toContain('Alt text')
            ->toContain('image1.png')
            ->toContain('Image heading')
            ->toContain('Image description');
    });

    test('can set the slide duration time on the carousel', function ($value) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'carousel' => [
                            'autoplay' => $value,
                        ],
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('intervalTime: '.$value);
    })->with([
        '0', '5000', '7500', '10000',
    ]);

    test('can display carousel arrows', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'carousel' => [
                            'arrows' => 'yes',
                        ],
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('aria-label="previous slide"')
            ->toContain('aria-label="next slide"');
    });

    test('can hide carousel arrows', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'carousel' => [
                            'arrows' => 'no',
                        ],
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->not->toContain('aria-label="previous slide"')
            ->not->toContain('aria-label="next slide"');
    });

    test('can set the corner radius of the carousel', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'carousel' => [
                            'radius' => $value,
                        ],
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
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

    test('can set the box shadow of the carousel', function ($value, $expected) {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'carousel' => [
                            'shadow' => $value,
                        ],
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
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

    test('renders carousel controls', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'image-gallery.carousel',
                'data' => [
                    'block' => [
                        'carousel' => [
                            'arrows' => 'yes',
                        ],
                        'images' => [
                            [
                                'src' => 'image1.png',
                                'alt' => 'Alt text',
                                'heading' => 'Image heading',
                                'description' => 'Image description',
                            ],
                        ],
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('aria-label="pause carousel"')
            ->toContain('aria-label="slides"');
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = CarouselImageGalleryBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(2);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = CarouselImageGalleryBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = CarouselImageGalleryBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $block = collect(PageBlockRegistry::blocks())->first(
        fn ($block) => $block instanceof CarouselImageGalleryBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(CarouselImageGalleryBlock::class);
});
