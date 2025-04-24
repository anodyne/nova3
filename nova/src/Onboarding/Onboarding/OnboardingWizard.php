<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding;

interface OnboardingWizard
{
    public function steps(): array;
}
