<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\from;
use function Pest\Laravel\get;

uses()->group('stories', 'storytelling');

beforeEach(function (): void {
    signIn(permissions: 'story.delete');
});

test('delete page includes the story and all descendants', function (): void {
    $story = Story::factory()->create();
    $child = Story::factory()->withParent($story)->create();
    $grandchild = Story::factory()->withParent($child)->create();
    $sibling = Story::factory()->withParent($story)->create();

    get(route('admin.stories.delete', $story))
        ->assertSuccessful()
        ->assertViewHas('storiesToDelete', function ($stories) use ($story, $child, $grandchild, $sibling): bool {
            $expectedIds = collect([$story->id, $child->id, $grandchild->id, $sibling->id])->sort()->values()->all();
            $actualIds = $stories->pluck('id')->sort()->values()->all();

            return $actualIds === $expectedIds;
        });
});

test('deleting posts also removes author pivot rows', function (): void {
    $story = Story::factory()
        ->has(Post::factory()->count(2)->published(), 'allPosts')
        ->create();

    $postIds = $story->allPosts()->pluck('id');

    expect(DB::table('post_author')->whereIn('post_id', $postIds)->count())->toBeGreaterThan(0);

    from(route('admin.stories.delete', $story))
        ->followingRedirects()
        ->delete(route('admin.stories.destroy'), [
            'actions' => json_encode([
                $story->id => [
                    'story' => ['action' => 'delete', 'actionId' => null],
                    'posts' => ['action' => 'delete', 'actionId' => null],
                ],
            ]),
        ])
        ->assertSuccessful();

    assertDatabaseMissing(Story::class, ['id' => $story->id]);
    expect(DB::table('post_author')->whereIn('post_id', $postIds)->count())->toBe(0);
});

test('delete page returns not found for an unknown story id', function (): void {
    get(route('admin.stories.delete', PHP_INT_MAX))->assertNotFound();
});

test('destroy ignores malformed actions payload', function (): void {
    $story = Story::factory()
        ->has(Post::factory()->count(2)->published(), 'allPosts')
        ->create();

    delete(route('admin.stories.destroy'), [
        'actions' => '{this-is-not-valid-json',
    ])->assertRedirectToRoute('admin.stories.index');

    assertDatabaseHas(Story::class, ['id' => $story->id]);
    expect($story->refresh()->allPosts()->count())->toBe(2);
});

test('destroy ignores unknown story ids and still applies valid actions', function (): void {
    $storyToDelete = Story::factory()
        ->has(Post::factory()->count(2)->published(), 'allPosts')
        ->create();

    $targetStory = Story::factory()->create();

    $storyWithInvalidMove = Story::factory()
        ->has(Post::factory()->count(2)->published(), 'allPosts')
        ->create();

    $postIdsInInvalidMoveStory = $storyWithInvalidMove->allPosts()->pluck('id');

    delete(route('admin.stories.destroy'), [
        'actions' => json_encode([
            PHP_INT_MAX => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'delete', 'actionId' => null],
            ],
            $storyToDelete->id => [
                'story' => ['action' => 'delete', 'actionId' => null],
                'posts' => ['action' => 'move', 'actionId' => $targetStory->id],
            ],
            $storyWithInvalidMove->id => [
                'story' => ['action' => 'move', 'actionId' => PHP_INT_MAX],
                'posts' => ['action' => 'move', 'actionId' => PHP_INT_MAX],
            ],
        ]),
    ])->assertRedirectToRoute('admin.stories.index');

    assertDatabaseMissing(Story::class, ['id' => $storyToDelete->id]);

    expect($targetStory->refresh()->allPosts()->count())->toBe(2);

    assertDatabaseHas(Story::class, ['id' => $storyWithInvalidMove->id, 'parent_id' => null]);
    expect(
        Post::query()
            ->whereKey($postIdsInInvalidMoveStory)
            ->where('story_id', $storyWithInvalidMove->id)
            ->count()
    )->toBe(2);
});

test('destroy without actions payload is a safe no-op', function (): void {
    $story = Story::factory()
        ->has(Post::factory()->count(2)->published(), 'allPosts')
        ->create();

    delete(route('admin.stories.destroy'), [])
        ->assertRedirectToRoute('admin.stories.index');

    assertDatabaseHas(Story::class, ['id' => $story->id]);
    expect($story->refresh()->allPosts()->count())->toBe(2);
});
