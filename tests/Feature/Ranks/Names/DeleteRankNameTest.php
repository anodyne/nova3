<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Ranks\Events\RankNameDeleted;
use Nova\Ranks\Livewire\RankNamesList;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('ranks');

beforeEach(function () {
    $this->rankNames = RankName::factory()->count(10)->create();

    signIn(permissions: 'rank.delete');
});

test('an authorized user can delete a rank name', function () {
    Event::fake();

    livewire(RankNamesList::class)
        ->callTableAction(DeleteAction::class, $this->rankNames->first())
        ->assertCanNotSeeTableRecords([$this->rankNames->first()])
        ->assertNotified();

    assertDatabaseMissing(RankName::class, $this->rankNames->first()->toArray());

    Event::assertDispatched(RankNameDeleted::class);
});

test('an authorized user can bulk delete rank names', function () {
    $rankNames = $this->rankNames->take(3);

    livewire(RankNamesList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $rankNames)
        ->assertNotified();

    foreach ($rankNames as $rankName) {
        assertDatabaseMissing(RankName::class, $rankName->toArray());
    }
});
