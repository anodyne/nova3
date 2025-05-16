<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\FreshInstall;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class ConfigureNotifications extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Configure notifications';
    }

    public function description(): ?string
    {
        return 'Nova 3 offers significantly more notifications than before. Take some time to go through the notifications and figure out which you would like to turn on and off, which should be delivered to the admin notifications panel, and which should be delivered through email.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.settings.notifications.edit');
    }
}
