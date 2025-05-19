<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\FreshInstall;

use Nova\Onboarding\Onboarding\OnboardingChecklist;

class FreshInstallOnboarding extends OnboardingChecklist
{
    /**
     * @return array<\Nova\Onboarding\Onboarding\OnboardingChecklistStep>
     */
    public function steps(): array
    {
        return $this->buildSteps([
            UpdateAppearance::class,
            SetContentRatings::class,
            ConfigureEmail::class,
            ConfigureNotifications::class,
            ExploreSettings::class,
            StartNewStory::class,
        ]);
    }
}
