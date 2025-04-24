<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding;

class FreshInstallOnboarding implements OnboardingWizard
{
    public function steps(): array
    {
        return [
            Steps\SetTimezone::class,
        ];
    }
}
