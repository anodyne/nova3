<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;
use Nova\Onboarding\Onboarding\OnboardingChecklist;

class NovaMigrationOnboarding extends OnboardingChecklist
{
    /**
     * @return array<OnboardingChecklistStep>
     */
    public function steps(): array
    {
        return $this->buildSteps([
            ConfigureEmail::class,
            CheckDepartmentsAndPositions::class,
            SetupRanks::class,
            UpdateCharacterRanks::class,
        ]);
    }
}
