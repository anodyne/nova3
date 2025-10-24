<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Ranks\Livewire\RankGroupsList;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('ranks');
uses()->group('rank-groups');

beforeEach(function () {
    $this->rankGroup = RankGroup::factory()->create();

    signIn(permissions: ['rank.create', 'rank.update']);
});

test('an authorized user can duplicate a rank group', function () {
    Event::fake();

    RankItem::factory()->create([
        'group_id' => $this->rankGroup->id,
    ]);

    $data = [
        'name' => 'New rank group',
        'base_image' => 'red.png',
    ];

    livewire(RankGroupsList::class)
        ->callAction(TestAction::make(ReplicateAction::class)->table($this->rankGroup), data: $data)
        ->assertHasNoFormErrors()
        ->assertNotified();

    assertDatabaseHas(RankGroup::class, Arr::only($data, 'name'));

    assertDatabaseHas(RankItem::class, Arr::only($data, 'base_image'));

    Event::assertDispatched(RankGroupDuplicated::class);
});
