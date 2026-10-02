<?php

declare(strict_types=1);

namespace Nova\Onboarding\Actions;

use Illuminate\Support\Facades\Date;
use Nova\Foundation\Actions\Action;
use Nova\Onboarding\Models\Onboarding;

class FinishOnboarding extends Action
{
    public function handle(Onboarding $model): Onboarding
    {
        $model->update(['completed_at' => Date::now()]);

        return $model->fresh();
    }
}
