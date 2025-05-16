<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class ConfigureEmail extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Configure email';
    }

    public function description(): ?string
    {
        return 'As part of the migration process, all users will be forced to reset their password. In order for that process to work as intended, you will need to ensure email is properly configured for your site.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.settings.email.edit');
    }
}
