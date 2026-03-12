<?php

declare(strict_types=1);

use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Blocks\Stories\AlternatingStoriesBlock;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\ButtonSize;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Livewire\AlternatingStories;
use Nova\Pages\Models\Page;
use Nova\Stories\Models\Story;

use function Pest\Livewire\livewire;

uses()->group('pages', 'page-blocks');

describe('rendered output', function () {
    test('renders block', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'timelineSorting' => 'asc',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('nv-stories-alternating');
    });

    test('renders story description when enabled', function () {
        $story = Story::factory()->completed()->create(['description' => 'This is my story description.']);

        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'showStoryDescription' => true,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('This is my story description.');
    });

    test('does not render story description when disabled', function () {
        $story = Story::factory()->completed()->create(['description' => 'This is my story description.']);

        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'showStoryDescription' => false,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->not->toContain('This is my story description.');
    });

    test('renders story stats when enabled', function () {
        $story = Story::factory()->completed()->create();

        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'showStoryStats' => true,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('nv-stories-story-stats');
    });

    test('does not render story stats when disabled', function () {
        $story = Story::factory()->completed()->create();

        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'showStoryStats' => false,
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->not->toContain('nv-stories-story-stats');
    });

    test('can set the primary text color', function () {
        $story = Story::factory()->completed()->create();

        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'primary-text-color' => '#121212',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--primary-text-color: #121212;');
    });

    test('can set the secondary text color', function () {
        $story = Story::factory()->completed()->create();

        $page = Page::factory()->basic()->published([
            [
                'type' => 'stories.alternating',
                'data' => [
                    'block' => [
                        'secondary-text-color' => '#555555',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)->toContain('--secondary-text-color: #555555;');
    });

    describe('go to story button', function () {
        beforeEach(fn () => Story::factory()->completed()->create());

        test('can set the button size', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'size' => $value,
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain($expected);
        })->with(
            collect(ButtonSize::cases())
                ->flatMap(fn (ButtonSize $size): array => [[$size->value, $size->getTailwindClasses()]])
        );

        test('can set the background color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'bg-color' => 'rgba(255, 255, 0, 1)',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('--bg-color: rgba(255, 255, 0, 1)');
        });

        test('can set the text color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'text-color' => 'rgba(255, 255, 255, 1)',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('--text-color: rgba(255, 255, 255, 1)');
        });

        test('can set the border color', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'border-color' => 'rgba(100, 100, 100, 1)',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('--border-color: rgba(100, 100, 100, 1)');
        });

        test('can set the border style to none', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'border-style' => 'none',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->not->toContain('ring-1 ring-(--border-color)');
        });

        test('can set the border style to outer', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'border-style' => 'outer',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('ring-1 ring-(--border-color)');
        });

        test('can set the border style to inner', function () {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
                                'border-style' => 'inner',
                            ],
                        ],
                    ],
                ],
            ])->create();

            $view = view('test-page-render', ['page' => $page]);
            $html = $view->render();

            expect($html)->toContain('ring-inset');
        });

        test('can set the corner radius', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
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

        test('can set the shadow', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'button' => [
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
    });

    describe('story image', function () {
        beforeEach(function () {
            $story = Story::factory()->completed()->create();

            $story->addMedia(base_path('tests/assets/image.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('story-image');
        });

        test('can set the corner radius', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'image' => [
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

        test('can set the shadow', function ($value, $expected) {
            $page = Page::factory()->basic()->published([
                [
                    'type' => 'stories.alternating',
                    'data' => [
                        'block' => [
                            'image' => [
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
    });
});

describe('livewire component', function () {
    test('showDescription returns true when block setting is enabled', function () {
        $component = livewire(AlternatingStories::class, [
            'blockSettings' => ['showStoryDescription' => true],
        ]);

        expect($component->instance()->showDescription)->toBeTrue();
    });

    test('showDescription returns false when block setting is disabled', function () {
        $component = livewire(AlternatingStories::class, [
            'blockSettings' => ['showStoryDescription' => false],
        ]);

        expect($component->instance()->showDescription)->toBeFalse();
    });

    test('showStats returns true when block setting is enabled', function () {
        $component = livewire(AlternatingStories::class, [
            'blockSettings' => ['showStoryStats' => true],
        ]);

        expect($component->instance()->showStats)->toBeTrue();
    });

    test('showStats returns false when block setting is disabled', function () {
        $component = livewire(AlternatingStories::class, [
            'blockSettings' => ['showStoryStats' => false],
        ]);

        expect($component->instance()->showStats)->toBeFalse();
    });

    test('returns current stories when type is current', function () {
        $currentStory = Story::factory()->current()->create(['title' => 'Current Story']);
        Story::factory()->upcoming()->create(['title' => 'Upcoming Story']);
        Story::factory()->completed()->create(['title' => 'Completed Story']);

        $component = livewire(AlternatingStories::class, ['type' => 'current']);
        $stories = $component->instance()->stories;

        expect($stories)
            ->toHaveCount(1)
            ->first()->title->toBe('Current Story');
    });

    test('returns upcoming stories when type is upcoming', function () {
        $upcomingStory = Story::factory()->upcoming()->create(['title' => 'Upcoming Story']);
        Story::factory()->current()->create(['title' => 'Current Story']);
        Story::factory()->completed()->create(['title' => 'Completed Story']);

        $component = livewire(AlternatingStories::class, ['type' => 'upcoming']);
        $stories = $component->instance()->stories;

        expect($stories)
            ->toHaveCount(1)
            ->first()->title->toBe('Upcoming Story');
    });

    test('returns ongoing stories when type is ongoing', function () {
        $ongoingStory = Story::factory()->ongoing()->create(['title' => 'Ongoing Story']);
        Story::factory()->current()->create(['title' => 'Current Story']);
        Story::factory()->completed()->create(['title' => 'Completed Story']);

        $component = livewire(AlternatingStories::class, ['type' => 'ongoing']);
        $stories = $component->instance()->stories;

        expect($stories)
            ->toHaveCount(1)
            ->first()->title->toBe('Ongoing Story');
    });

    test('returns selected stories when type is custom', function () {
        $story1 = Story::factory()->current()->create(['title' => 'Story 1']);
        $story2 = Story::factory()->upcoming()->create(['title' => 'Story 2']);
        $story3 = Story::factory()->completed()->create(['title' => 'Story 3']);

        $component = livewire(AlternatingStories::class, [
            'type' => 'custom',
            'blockSettings' => [
                'selectedStories' => [$story1->id, $story3->id],
            ],
        ]);
        $stories = $component->instance()->stories;

        expect($stories)
            ->toHaveCount(2)
            ->pluck('title')->toArray()
            ->toContain('Story 1')
            ->toContain('Story 3')
            ->not->toContain('Story 2');
    });

    test('returns all stories when type is null', function () {
        Story::factory()->current()->create();
        Story::factory()->upcoming()->create();
        Story::factory()->completed()->create();

        $component = livewire(AlternatingStories::class, ['type' => null]);
        $stories = $component->instance()->stories;

        expect($stories)->toHaveCount(3);
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = AlternatingStoriesBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(3);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = AlternatingStoriesBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = AlternatingStoriesBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $block = collect(PageBlockRegistry::blocks())->first(
        fn ($block) => $block instanceof AlternatingStoriesBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(AlternatingStoriesBlock::class);
});
