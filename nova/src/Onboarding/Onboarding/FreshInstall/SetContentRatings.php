<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\FreshInstall;

use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class SetContentRatings extends OnboardingChecklistStep
{
    public function label(): string
    {
        return 'Set content ratings';
    }

    public function description(): ?string
    {
        return 'Nova 3 integrates a familiar rating system that allows you to set the content ratings for the game and for authors to set the content ratings of individual posts. Before players start posting, take a few minutes to setup your content ratings.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.settings.content-ratings.edit');
    }
}
