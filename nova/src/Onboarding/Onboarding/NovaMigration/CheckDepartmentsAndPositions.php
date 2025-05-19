<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class CheckDepartmentsAndPositions extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Check departments & positions';
    }

    public function description(): ?string
    {
        return 'During the migration process, your existing departments and positions were migrated to the new format. You should verify that your departments and positions are configured the way you want.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.departments.index');
    }
}
