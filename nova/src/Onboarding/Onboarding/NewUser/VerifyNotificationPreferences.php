<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NewUser;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class VerifyNotificationPreferences extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Set notification preferences';
    }

    public function description(): ?string
    {
        return 'Verify your personal notification preferences so you don’t miss communications from the game.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.account.notifications');
    }
}
