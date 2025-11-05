<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Foundation\Models\StatusHistory;

use function Pest\Laravel\assertDatabaseHas;

it('creates new status history record for user', function () {
    $character = Character::factory()->create();

    TrackStatusUpdate::run($character);

    assertDatabaseHas(StatusHistory::class, [
        'statusable_type' => 'character',
        'statusable_id' => $character->id,
        'status' => 'active',
        'started_at' => Date::now(),
        'ended_at' => null,
    ]);
});

it('closes current status history and creates new one for user', function () {
    $character = Character::factory()->create();

    TrackStatusUpdate::run($character);

    TrackStatusUpdate::run($character);

    assertDatabaseHas(StatusHistory::class, [
        'statusable_type' => 'character',
        'statusable_id' => $character->id,
        'started_at' => Date::now(),
        'ended_at' => Date::now(),
        'status' => 'active',
    ]);
});
