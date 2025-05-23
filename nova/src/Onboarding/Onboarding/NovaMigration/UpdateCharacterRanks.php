<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NovaMigration;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class UpdateCharacterRanks extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Update character ranks';
    }

    public function description(): ?string
    {
        return 'You will need to set the ranks for all characters after you have setup your ranks the way you want.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.characters.migrate-ranks');
    }
}
