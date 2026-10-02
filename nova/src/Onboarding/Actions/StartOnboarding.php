<?php

declare(strict_types=1);

namespace Nova\Onboarding\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;
use Nova\Users\Models\User;

class StartOnboarding extends Action
{
    public function handle(OnboardingProcess $process, User $user): Onboarding
    {
        $model = Onboarding::create([
            'process' => $process,
            'user_id' => $user->id,
        ]);

        return $model->fresh();
    }
}
