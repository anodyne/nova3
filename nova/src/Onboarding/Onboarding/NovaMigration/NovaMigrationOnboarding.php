<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklist;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

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
