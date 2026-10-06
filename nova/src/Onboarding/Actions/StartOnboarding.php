<?php

declare(strict_types=1);

namespace Nova\Onboarding\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;
use Nova\Users\Models\User;

class StartOnboarding extends Action
{
    public function handle(OnboardingProcess $process, User $user): Onboarding
    {
        return DB::transaction(function () use ($process, $user) {
            $model = Onboarding::create([
                'process' => $process,
                'user_id' => $user->id,
            ]);

            $initialStepsData = collect($model->process->make($model)->steps())
                ->flatMap(fn (OnboardingChecklistStep $step): array => [$step->key() => false])
                ->toArray();

            $model->steps = $initialStepsData;
            $model->save();

            return $model->fresh();
        });
    }
}
