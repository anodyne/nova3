<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class SetupRanks extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Setup ranks';
    }

    public function description(): ?string
    {
        return 'Due to the vastly different structure of ranks, we are not able to migrate your ranks. You should go through and ensure ranks are setup the way that you want for your game.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.ranks.items.index');
    }
}
