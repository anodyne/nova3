<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NewUser;

use Illuminate\Support\Facades\Auth;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class ActivePrimaryCharacter extends OnboardingChecklistStep
{
    public function isComplete(): bool
    {
        return Auth::user()->primaryCharacter()->count() > 0;
    }

    public function label(): string
    {
        return 'Have an active primary character';
    }

    public function description(): ?string
    {
        return 'Depending on how this Nova instance is configured, you may not be able to do this yourself. If you cannot create a character or set a character as your primary character, reach out to the Game Master for help with this step.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.characters.index', ['only_my_characters' => true]);
    }
}
