<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Ranks\Events\RankItemDeleted;
use Nova\Ranks\Livewire\RankItemsList;
use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('ranks');

beforeEach(function () {
    $this->rankItems = RankItem::factory()->count(10)->create();

    signIn(permissions: 'rank.delete');
});

test('an authorized user can delete a rank item', function () {
    Event::fake();

    livewire(RankItemsList::class)
        ->callTableAction(DeleteAction::class, $this->rankItems->first())
        ->assertCanNotSeeTableRecords([$this->rankItems->first()])
        ->assertNotified();

    assertDatabaseMissing(RankItem::class, Arr::except($this->rankItems->first()->toArray(), 'name'));

    Event::assertDispatched(RankItemDeleted::class);
});

test('an authorized user can bulk delete rank groups', function () {
    $rankItems = $this->rankItems->take(3);

    livewire(RankItemsList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $rankItems)
        ->assertNotified();

    foreach ($rankItems as $rankItem) {
        assertDatabaseMissing(RankItem::class, Arr::except($rankItem->toArray(), 'name'));
    }
});
