<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Ranks\Events\RankNameDuplicated;
use Nova\Ranks\Livewire\RankNamesList;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('ranks');

beforeEach(function () {
    $this->rankName = RankName::factory()->create();

    signIn(permissions: ['rank.create', 'rank.update']);
});

test('an authorized user can duplicate a rank name', function () {
    Event::fake();

    $data = [
        'name' => 'New rank name',
    ];

    livewire(RankNamesList::class)
        ->callTableAction(ReplicateAction::class, $this->rankName, data: $data)
        ->assertNotified();

    assertDatabaseHas(RankName::class, $data);

    Event::assertDispatched(RankNameDuplicated::class);
});
