<?php

declare(strict_types=1);

namespace Nova\Onboarding\Observers;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Nova\Onboarding\Models\Onboarding;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class OnboardingObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Onboarding $onboarding): void
    {
        $initialStepsData = collect($onboarding->process->make($onboarding)->steps())
            ->flatMap(fn (OnboardingChecklistStep $step): array => [$step->key() => false])
            ->toArray();

        $onboarding->steps = $initialStepsData;
        $onboarding->save();
    }
}
