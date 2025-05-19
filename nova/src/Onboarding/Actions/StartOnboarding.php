<?php

declare(strict_types=1);

namespace Nova\Onboarding\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;
use Nova\Users\Models\User;

class StartOnboarding
{
    use AsAction;

    public function handle(OnboardingProcess $process, User $user): Onboarding
    {
        $model = Onboarding::create([
            'process' => $process,
            'user_id' => $user->id,
        ]);

        return $model->fresh();
    }
}
