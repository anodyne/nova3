<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PublishedPostsList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

use function Pest\Laravel\get;

uses()->group('stories', 'storytelling');

beforeEach(function () {
    $this->story = Story::factory()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'story.view'));

    test('can view the view story page', function () {
        get(route('admin.stories.show', $this->story))->assertSuccessful();
    });

    test('view story page includes loaded story stats and ancestor context', function (): void {
        $ancestor = Story::factory()->create();
        $parent = Story::factory()->withParent($ancestor)->create();
        $story = Story::factory()->withParent($parent)->create();

        Post::factory()->count(2)->published()->withStory($story)->create();

        $expectedWordCount = $story->allPosts()->sum('word_count');

        get(route('admin.stories.show', $story))
            ->assertSuccessful()
            ->assertSeeLivewire(PublishedPostsList::class)
            ->assertViewHas('story', function (Story $viewStory) use ($story, $expectedWordCount): bool {
                return $viewStory->is($story)
                    && $viewStory->posts_count === 2
                    && (int) $viewStory->posts_sum_word_count === (int) $expectedWordCount
                    && $viewStory->children_count === 0;
            })
            ->assertViewHas('ancestors', function ($ancestors) use ($ancestor, $story): bool {
                return $ancestors->isNotEmpty()
                    && $ancestors->contains(fn (Story $ancestorStory): bool => $ancestorStory->is($ancestor))
                    && $ancestors->doesntContain(fn (Story $ancestorStory): bool => $ancestorStory->is($story));
            });
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the view story page', function () {
        get(route('admin.stories.show', $this->story))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view story page', function () {
        get(route('admin.stories.show', $this->story))
            ->assertRedirectToRoute('login');
    });
});
