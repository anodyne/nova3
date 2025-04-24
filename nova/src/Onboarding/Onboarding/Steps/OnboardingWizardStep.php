<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\Steps;

interface OnboardingWizardStep
{
    public function label(): string;
}
