<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class TrackStatusUpdate extends Action
{
    public function handle(Character|User $model): void
    {
        DB::transaction(function () use ($model) {
            $currentStatus = $model->statusHistories()->whereNull('ended_at')->first();

            $currentStatus?->update(['ended_at' => now()]);

            $model->statusHistories()->create([
                'status' => 'active',
                'started_at' => now(),
            ]);
        });
    }
}
