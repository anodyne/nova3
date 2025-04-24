<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\Steps;

class UpdateTimezone implements OnboardingWizardStep
{
    public function label(): string
    {
        return 'Update your timezone';
    }
}
