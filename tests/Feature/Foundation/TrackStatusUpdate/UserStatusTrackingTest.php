<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Foundation\Models\StatusHistory;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;

it('creates new status history record for user', function () {
    $user = User::factory()->create();

    TrackStatusUpdate::run($user);

    assertDatabaseHas(StatusHistory::class, [
        'statusable_type' => 'user',
        'statusable_id' => $user->id,
        'status' => 'active',
        'started_at' => Date::now(),
        'ended_at' => null,
    ]);
});

it('closes current status history and creates new one for user', function () {
    $user = User::factory()->create();

    TrackStatusUpdate::run($user);

    TrackStatusUpdate::run($user);

    assertDatabaseHas(StatusHistory::class, [
        'statusable_type' => 'user',
        'statusable_id' => $user->id,
        'started_at' => Date::now(),
        'ended_at' => Date::now(),
        'status' => 'active',
    ]);
});
