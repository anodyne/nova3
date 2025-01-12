<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class TrackStatusUpdate
{
    use AsAction;

    public function handle(Character|User $model): void
    {
        $currentStatus = $model->statusHistories()->whereNull('ended_at')->first();

        if ($currentStatus) {
            $currentStatus->update(['ended_at' => now()]);
        }

        $model->statusHistories()->create([
            'status' => 'active',
            'started_at' => now(),
        ]);
    }
}
