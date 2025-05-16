<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\FreshInstall;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class ConfigureEmail extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Configure email';
    }

    public function description(): ?string
    {
        return 'While we have tried to limit how much email is used, there are still places where email will be required. Ensure your email is properly configured (setting a driver, setting your from email address).';
    }

    public function linkUrl(): ?string
    {
        return route('admin.settings.email.edit');
    }
}
