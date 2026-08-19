<?php

declare(strict_types=1);

namespace Nova\Onboarding\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Nova\Onboarding\Data\DashboardOnboardingData;
use Nova\Onboarding\Models\Onboarding;

trait GetActiveOnboardingsForCurrentUser
{
    protected function getActiveOnboardingsForCurrentUser(bool $sync): Collection
    {
        return Onboarding::query()
            ->user(Auth::user())
            ->incomplete()
            ->get()
            ->map(function (Onboarding $onboarding) use ($sync): DashboardOnboardingData {
                $onboardingChecklist = $onboarding->process->make($onboarding);

                if ($sync) {
                    $onboardingChecklist->syncSteps();
                }

                return DashboardOnboardingData::from(
                    model: $onboarding,
                    label: $onboarding->process->getLabel(),
                    description: $onboarding->process->getDescription(),
                    percentComplete: $onboardingChecklist->percentComplete(),
                    ctaLabel: $onboarding->process->getCallToActionLabel()
                );
            });
    }
}
