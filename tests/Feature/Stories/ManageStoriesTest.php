<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Stories\Livewire\StoriesList;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('stories', 'storytelling');

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
    beforeEach(fn () => signIn(permissions: 'story.create'));

    test('can view the list stories page', function () {
        get(route('admin.stories.index'))->assertSuccessful();

        livewire(StoriesList::class)
            ->assertCanSeeTableRecords($this->stories->where('status', '!=', Completed::$name))
            ->assertCanNotSeeTableRecords($this->stories->where('status', Completed::$name));
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
        $parentStory = Story::factory()->upcoming()->create();
        $childStories = Story::factory()->count(5)->upcoming()->withParent($parentStory)->create();

        livewire(StoriesList::class)
            ->filterTable('has_parent_story', true)
            ->assertCanSeeTableRecords($childStories)
            ->assertCanNotSeeTableRecords($this->stories);
    });

    test('can filter stories by parent story', function () {
        $parentStory = Story::factory()->upcoming()->create();

        $matchingStories = Story::factory()->count(5)->upcoming()->withParent($parentStory)->create();
        $otherParentStory = Story::factory()->upcoming()->create();
        $nonMatchingStories = Story::factory()->count(3)->upcoming()->withParent($otherParentStory)->create();

        livewire(StoriesList::class)
            ->filterTable('parent_id', $parentStory->id)
            ->assertCanSeeTableRecords($matchingStories)
            ->assertCanNotSeeTableRecords($nonMatchingStories);
    });

    test('can search stories by title', function () {
        Story::factory()->upcoming()->create(['title' => 'A test story title']);

        livewire(StoriesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable('test story')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with story create permissions', function () {
    beforeEach(fn () => signIn(permissions: 'story.create'));

    test('has the correct permissions', function () {
        $story = $this->stories->first();

        livewire(StoriesList::class)
            ->assertTableActionHidden(ViewAction::class, $story)
            ->assertTableActionHidden(EditAction::class, $story)
            ->assertTableActionHidden(DeleteAction::class, $story)
            ->assertTableActionHidden('dates', $story);
    });
});

describe('authorized user with story delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'story.delete');
    });

    test('has the correct permissions', function () {
        $story = $this->stories->first();

        livewire(StoriesList::class)
            ->assertTableActionHidden(ViewAction::class, $story)
            ->assertTableActionHidden(EditAction::class, $story)
            ->assertTableActionVisible(DeleteAction::class, $story)
            ->assertTableActionHidden('dates', $story);
    });
});

describe('authorized user with story update permissions', function () {
    beforeEach(fn () => signIn(permissions: 'story.update'));

    test('has the correct permissions', function () {
        $story = Story::factory()->completed()->create();

        livewire(StoriesList::class)
            ->filterTable('status', Completed::$name)
            ->assertTableActionHidden(ViewAction::class, $story)
            ->assertTableActionVisible(EditAction::class, $story)
            ->assertTableActionHidden(DeleteAction::class, $story)
            ->assertTableActionVisible('dates', $story);
    });

    test('can update the dates of a completed story', function () {
        $story = Story::factory()->completed()->create([
            'started_at' => Date::now()->subMonth()->startOfDay(),
            'ended_at' => Date::now()->subDay()->startOfDay(),
        ]);

        livewire(StoriesList::class)
            ->filterTable('status', Completed::$name)
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
});

describe('authorized user with story view permissions', function () {
    beforeEach(fn () => signIn(permissions: 'story.view'));

    test('has the correct permissions', function () {
        $story = $this->stories->first();

        livewire(StoriesList::class)
            ->assertTableActionVisible(ViewAction::class, $story)
            ->assertTableActionHidden(EditAction::class, $story)
            ->assertTableActionHidden(DeleteAction::class, $story)
            ->assertTableActionHidden('dates', $story);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage stories page', function () {
        get(route('admin.stories.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage stories page', function () {
        get(route('admin.stories.index'))
            ->assertRedirectToRoute('login');
    });
});
