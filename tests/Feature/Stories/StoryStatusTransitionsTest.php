<?php

declare(strict_types=1);

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Nova\Stories\Actions\UpdateStoryStatus;
use Nova\Stories\Events\StoryEnded as StoryEndedEvent;
use Nova\Stories\Events\StoryStarted as StoryStartedEvent;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Ongoing;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\StoryEnded;
use Nova\Stories\Notifications\StoryStarted;

uses()->group('stories', 'storytelling');

beforeEach(function (): void {
    signIn(permissions: 'story.update');
});

test('it applies all allowed story status transitions', function (
    string $fromStatus,
    string $toStatus,
    string $expectedStartedAt,
    string $expectedEndedAt,
    bool $expectsStoryStartedNotification,
    bool $expectsStoryEndedNotification,
    bool $expectsStoryStartedEvent,
    bool $expectsStoryEndedEvent
): void {
    Notification::fake();
    Event::fake([
        StoryStartedEvent::class,
        StoryEndedEvent::class,
    ]);

    $initialStartedAt = now()->subDays(5)->startOfHour();
    $initialEndedAt = now()->subDays(2)->startOfHour();

    $story = buildStoryForStatusTransitionTest(
        status: $fromStatus,
        startedAt: $initialStartedAt,
        endedAt: $initialEndedAt,
    );

    $originalStartedAt = $story->started_at;
    $originalEndedAt = $story->ended_at;

    UpdateStoryStatus::run($story, $toStatus);

    $story->refresh();

    expect($story->status->name())->toBe($toStatus);

    assertDateValueForTransition(
        value: $story->started_at,
        expectedState: $expectedStartedAt,
        unchangedValue: $originalStartedAt
    );

    assertDateValueForTransition(
        value: $story->ended_at,
        expectedState: $expectedEndedAt,
        unchangedValue: $originalEndedAt
    );

    if ($expectsStoryStartedNotification) {
        Notification::assertSentTo(auth()->user(), StoryStarted::class);
    } else {
        Notification::assertNotSentTo(auth()->user(), StoryStarted::class);
    }

    if ($expectsStoryEndedNotification) {
        Notification::assertSentTo(auth()->user(), StoryEnded::class);
    } else {
        Notification::assertNotSentTo(auth()->user(), StoryEnded::class);
    }

    if ($expectsStoryStartedEvent) {
        Event::assertDispatched(StoryStartedEvent::class);
    } else {
        Event::assertNotDispatched(StoryStartedEvent::class);
    }

    if ($expectsStoryEndedEvent) {
        Event::assertDispatched(StoryEndedEvent::class);
    } else {
        Event::assertNotDispatched(StoryEndedEvent::class);
    }
})->with('story-status-transitions');

test('it transitions the parent story to ongoing when a child becomes current', function (): void {
    $parent = Story::factory()->upcoming()->create([
        'started_at' => null,
        'ended_at' => null,
    ]);

    $child = buildStoryForStatusTransitionTest(
        status: Upcoming::$name,
        startedAt: now()->subDays(5),
        endedAt: now()->subDays(2),
        parent: $parent
    );

    UpdateStoryStatus::run($child, Current::$name);

    $parent->refresh();

    expect($parent->status->name())->toBe(Ongoing::$name)
        ->and($parent->started_at?->isSameSecond(now()))->toBeTrue()
        ->and($parent->ended_at)->toBeNull();
});

test('it transitions the parent story to completed when the last active child is completed', function (): void {
    $parent = Story::factory()->current()->create([
        'started_at' => now()->subDays(10),
        'ended_at' => null,
    ]);

    $child = buildStoryForStatusTransitionTest(
        status: Current::$name,
        startedAt: now()->subDays(5),
        endedAt: now()->subDays(2),
        parent: $parent
    );

    UpdateStoryStatus::run($child, Completed::$name);

    $parent->refresh();

    expect($parent->status->name())->toBe(Completed::$name)
        ->and($parent->ended_at?->isSameSecond(now()))->toBeTrue();
});

test('it does not transition the parent story to completed when another child remains active', function (): void {
    $parent = Story::factory()->current()->create([
        'started_at' => now()->subDays(10),
        'ended_at' => null,
    ]);

    $child = buildStoryForStatusTransitionTest(
        status: Current::$name,
        startedAt: now()->subDays(5),
        endedAt: now()->subDays(2),
        parent: $parent
    );

    buildStoryForStatusTransitionTest(
        status: Upcoming::$name,
        startedAt: now()->subDays(4),
        endedAt: now()->subDays(1),
        parent: $parent
    );

    UpdateStoryStatus::run($child, Completed::$name);

    $parent->refresh();

    expect($parent->status->name())->toBe(Current::$name)
        ->and($parent->ended_at)->toBeNull();
});

dataset('story-status-transitions', [
    'upcoming -> completed' => [
        Upcoming::$name,
        Completed::$name,
        'now',
        'now',
        false,
        false,
        false,
        false,
    ],
    'upcoming -> current' => [
        Upcoming::$name,
        Current::$name,
        'now',
        'null',
        true,
        false,
        true,
        false,
    ],
    'upcoming -> ongoing' => [
        Upcoming::$name,
        Ongoing::$name,
        'now',
        'null',
        false,
        false,
        false,
        false,
    ],
    'current -> completed' => [
        Current::$name,
        Completed::$name,
        'unchanged',
        'now',
        false,
        true,
        false,
        true,
    ],
    'current -> ongoing' => [
        Current::$name,
        Ongoing::$name,
        'unchanged',
        'unchanged',
        false,
        false,
        false,
        false,
    ],
    'current -> upcoming' => [
        Current::$name,
        Upcoming::$name,
        'null',
        'null',
        false,
        false,
        false,
        false,
    ],
    'ongoing -> completed' => [
        Ongoing::$name,
        Completed::$name,
        'unchanged',
        'now',
        false,
        false,
        false,
        false,
    ],
    'ongoing -> current' => [
        Ongoing::$name,
        Current::$name,
        'unchanged',
        'unchanged',
        false,
        false,
        false,
        false,
    ],
    'ongoing -> upcoming' => [
        Ongoing::$name,
        Upcoming::$name,
        'null',
        'null',
        false,
        false,
        false,
        false,
    ],
    'completed -> current' => [
        Completed::$name,
        Current::$name,
        'unchanged',
        'null',
        false,
        false,
        false,
        false,
    ],
    'completed -> ongoing' => [
        Completed::$name,
        Ongoing::$name,
        'unchanged',
        'null',
        false,
        false,
        false,
        false,
    ],
    'completed -> upcoming' => [
        Completed::$name,
        Upcoming::$name,
        'null',
        'null',
        false,
        false,
        false,
        false,
    ],
]);

function buildStoryForStatusTransitionTest(
    string $status,
    CarbonInterface $startedAt,
    CarbonInterface $endedAt,
    ?Story $parent = null
): Story {
    return Story::factory()->create([
        'status' => $status,
        'parent_id' => $parent?->id,
        'started_at' => match ($status) {
            Upcoming::$name => null,
            default => $startedAt,
        },
        'ended_at' => match ($status) {
            Completed::$name => $endedAt,
            default => null,
        },
    ]);
}

function assertDateValueForTransition(?CarbonInterface $value, string $expectedState, ?CarbonInterface $unchangedValue): void
{
    match ($expectedState) {
        'now' => expect($value?->isSameSecond(now()))->toBeTrue(),
        'null' => expect($value)->toBeNull(),
        'unchanged' => filled($unchangedValue)
            ? expect($value?->isSameSecond($unchangedValue))->toBeTrue()
            : expect($value)->toBeNull(),
    };
}
