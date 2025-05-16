<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NewUser;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class UpdateTimezone extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Update your timezone';
    }

    public function description(): ?string
    {
        return 'Nova utilizes your configured timezone to display dates and times to you. Make sure your timezone matches where you are so you’ll see accurate dates and times.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.account.edit');
    }
}
