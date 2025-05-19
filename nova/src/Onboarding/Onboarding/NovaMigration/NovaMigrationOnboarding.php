<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklist;

class NovaMigrationOnboarding extends OnboardingChecklist
{
    /**
     * @return array<\Nova\Onboarding\Onboarding\OnboardingChecklistStep>
     */
    public function steps(): array
    {
        return $this->buildSteps([
            ConfigureEmail::class,
            CheckDepartmentsAndPositions::class,
            SetupRanks::class,
            UpdateCharacterInfo::class,
        ]);
    }
}
