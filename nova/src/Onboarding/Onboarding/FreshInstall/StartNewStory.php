<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\FreshInstall;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;
use Nova\Stories\Models\Story;

class StartNewStory extends OnboardingChecklistStep
{
    public function isComplete(): bool
    {
        return once(fn (): bool => Story::query()->exceptCompleted()->count() > 0);
    }

    public function label(): string
    {
        return 'Start a story';
    }

    public function description(): ?string
    {
        return 'Begin crafting your first story to give players a starting point in the game.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.stories.index');
    }
}
