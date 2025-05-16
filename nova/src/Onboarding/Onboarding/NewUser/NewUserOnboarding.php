<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NewUser;

use Nova\Onboarding\Onboarding\OnboardingChecklist;

class NewUserOnboarding extends OnboardingChecklist
{
    /**
     * @return array<\Nova\Onboarding\Onboarding\OnboardingChecklistStep>
     */
    public function steps(): array
    {
        return $this->buildSteps([
            AddUserPhoto::class,
            VerifyNotificationPreferences::class,
            UpdateTimezone::class,
            ActivePrimaryCharacter::class,
            WriteStoryPost::class,
        ]);
    }
}
