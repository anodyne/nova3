<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Ranks\Events\RankGroupDeleted;
use Nova\Ranks\Livewire\RankGroupsList;
use Nova\Ranks\Models\RankGroup;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('ranks');
uses()->group('rank-groups');

beforeEach(function () {
    $this->rankGroups = RankGroup::factory()->count(10)->create();

    signIn(permissions: 'rank.delete');
});

test('an authorized user can delete a rank group', function () {
    Event::fake();

    livewire(RankGroupsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($this->rankGroups->first()))
        ->assertCanNotSeeTableRecords([$this->rankGroups->first()])
        ->assertNotified();

    assertDatabaseMissing(RankGroup::class, $this->rankGroups->first()->toArray());

    Event::assertDispatched(RankGroupDeleted::class);
});

test('an authorized user can bulk delete rank groups', function () {
    $rankGroups = $this->rankGroups->take(3);

    livewire(RankGroupsList::class)
        ->selectTableRecords($rankGroups->pluck('id')->toArray())
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertNotified();

    foreach ($rankGroups as $rankGroup) {
        assertDatabaseMissing(RankGroup::class, $rankGroup->toArray());
    }
});
