<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Notification;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Stories\Livewire\StoriesList;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\StoryEnded;
use Nova\Stories\Notifications\StoryStarted;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('stories');

beforeEach(function () {
    $this->stories = Story::factory()
        ->count(9)
        ->sequence(
            ['status' => Upcoming::$name],
            ['status' => Current::$name],
            ['status' => Completed::$name],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'story.create');
    });

    test('can view the list stories page', function () {
        get(route('stories.index'))->assertSuccessful();

        livewire(StoriesList::class)
            ->assertCanSeeTableRecords($this->stories);
    });

    test('can filter stories by status', function () {
        livewire(StoriesList::class)
            ->filterTable('status', Upcoming::$name)
            ->assertCanSeeTableRecords($this->stories->where('status', Upcoming::$name))
            ->assertCanNotSeeTableRecords($this->stories->where('status', '!=', Upcoming::$name))
            ->resetTableFilters()
            ->filterTable('status', Current::$name)
            ->assertCanSeeTableRecords($this->stories->where('status', Current::$name))
            ->assertCanNotSeeTableRecords($this->stories->where('status', '!=', Current::$name))
            ->resetTableFilters()
            ->filterTable('status', Completed::$name)
            ->assertCanSeeTableRecords($this->stories->where('status', Completed::$name))
            ->assertCanNotSeeTableRecords($this->stories->where('status', '!=', Completed::$name));
    });

    test('can filter stories by presence of a parent story', function () {
        Story::factory()->count(5)->withParent($this->stories->first())->create();

        livewire(StoriesList::class)
            ->filterTable('has_parent_story', true)
            ->assertCanSeeTableRecords(Story::whereNotNull('parent_id')->get())
            ->assertCanNotSeeTableRecords(Story::whereNull('parent_id')->get());
    });

    test('can filter stories by parent story', function () {
        $parentStoryId = $this->stories->first()->id;

        Story::factory()->count(5)->withParent($this->stories->first())->create();

        livewire(StoriesList::class)
            ->filterTable('parent_id', $parentStoryId)
            ->assertCanSeeTableRecords(Story::where('parent_id', $parentStoryId)->get())
            ->assertCanNotSeeTableRecords(Story::where('parent_id', '!=', $parentStoryId)->get());
    });

    test('can search stories by title', function () {
        Story::factory()->create(['title' => 'A test story title']);

        livewire(StoriesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable('test story')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with story create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'story.create');
    });

    test('has the correct permissions', function () {
        livewire(StoriesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->stories->first())
            ->assertTableActionHidden(EditAction::class, $this->stories->first())
            ->assertTableActionHidden(DeleteAction::class, $this->stories->first())
            ->assertTableActionHidden('dates', $this->stories->first())
            ->assertTableActionHidden('status_upcoming', $this->stories->first())
            ->assertTableActionHidden('status_current', $this->stories->first())
            ->assertTableActionHidden('status_ongoing', $this->stories->first())
            ->assertTableActionHidden('status_completed', $this->stories->first());
    });
});

describe('authorized user with story delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'story.delete');
    });

    test('has the correct permissions', function () {
        livewire(StoriesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->stories->first())
            ->assertTableActionHidden(EditAction::class, $this->stories->first())
            ->assertTableActionVisible(DeleteAction::class, $this->stories->first())
            ->assertTableActionHidden('dates', $this->stories->first())
            ->assertTableActionHidden('status_upcoming', $this->stories->first())
            ->assertTableActionHidden('status_current', $this->stories->first())
            ->assertTableActionHidden('status_ongoing', $this->stories->first())
            ->assertTableActionHidden('status_completed', $this->stories->first());
    });
});

describe('authorized user with story update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'story.update');
    });

    test('has the correct permissions', function () {
        livewire(StoriesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->stories->first())
            ->assertTableActionVisible(EditAction::class, $this->stories->first())
            ->assertTableActionHidden(DeleteAction::class, $this->stories->first());
    });

    test('can update the dates of a completed story', function () {
        $story = Story::factory()->completed()->create([
            'started_at' => Date::now()->subMonth()->startOfDay(),
            'ended_at' => Date::now()->subDay()->startOfDay(),
        ]);

        livewire(StoriesList::class)
            ->assertTableActionVisible('dates', $story)
            ->callTableAction('dates', $story, data: [
                'start_date' => $startDate = $story->started_at->copy()->addDay(),
                'end_date' => $endDate = $story->ended_at->copy()->addDay(),
            ])
            ->assertNotified();

        assertDatabaseHas(Story::class, [
            'title' => $story->title,
            'started_at' => $startDate,
            'ended_at' => $endDate,
        ]);
    });

    test('cannot update the dates of a non-completed story', function () {
        $story = Story::factory()->current()->create();

        livewire(StoriesList::class)
            ->assertTableActionHidden('dates', $story);
    });

    test('can update the status of a story to upcoming', function () {
        $story = Story::factory()->current()->create();

        livewire(StoriesList::class)
            ->assertTableActionVisible('status_upcoming', $story)
            ->callTableAction('status_upcoming', $story);

        assertDatabaseHas(Story::class, [
            'title' => $story->title,
            'status' => 'upcoming',
        ]);
    });

    test('can update the status of a story to current', function () {
        Notification::fake();

        $story = Story::factory()->upcoming()->create();

        livewire(StoriesList::class)
            ->assertTableActionVisible('status_current', $story)
            ->callTableAction('status_current', $story);

        assertDatabaseHas(Story::class, [
            'title' => $story->title,
            'status' => 'current',
        ]);

        Notification::assertSentTo(Auth::user(), StoryStarted::class);
    });

    test('can update the status of a story to completed', function () {
        Notification::fake();

        $story = Story::factory()->current()->create();

        livewire(StoriesList::class)
            ->assertTableActionVisible('status_completed', $story)
            ->callTableAction('status_completed', $story);

        assertDatabaseHas(Story::class, [
            'title' => $story->title,
            'status' => 'completed',
        ]);

        Notification::assertSentTo(Auth::user(), StoryEnded::class);
    });

    test('can update the status of a story to ongoing', function () {
        $story = Story::factory()->upcoming()->create();

        livewire(StoriesList::class)
            ->assertTableActionVisible('status_ongoing', $story)
            ->callTableAction('status_ongoing', $story);

        assertDatabaseHas(Story::class, [
            'title' => $story->title,
            'status' => 'ongoing',
        ]);
    });
});

describe('authorized user with story view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'story.view');
    });

    test('has the correct permissions', function () {
        livewire(StoriesList::class)
            ->assertTableActionVisible(ViewAction::class, $this->stories->first())
            ->assertTableActionHidden(EditAction::class, $this->stories->first())
            ->assertTableActionHidden(DeleteAction::class, $this->stories->first())
            ->assertTableActionHidden('dates', $this->stories->first())
            ->assertTableActionHidden('status_upcoming', $this->stories->first())
            ->assertTableActionHidden('status_current', $this->stories->first())
            ->assertTableActionHidden('status_ongoing', $this->stories->first())
            ->assertTableActionHidden('status_completed', $this->stories->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage stories page', function () {
        get(route('stories.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage stories page', function () {
        get(route('stories.index'))
            ->assertRedirectToRoute('login');
    });
});
