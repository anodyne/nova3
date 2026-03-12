<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\FreshInstall;

use Nova\Onboarding\Onboarding\OnboardingChecklist;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class FreshInstallOnboarding extends OnboardingChecklist
{
    /**
     * @return array<OnboardingChecklistStep>
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
