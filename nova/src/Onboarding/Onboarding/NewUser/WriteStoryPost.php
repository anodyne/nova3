<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NewUser;

use Illuminate\Support\Facades\Auth;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class WriteStoryPost extends OnboardingChecklistStep
{
    public function isComplete(): bool
    {
        return Auth::user()->posts()->count() > 0;
    }

    public function label(): string
    {
        return 'Write your first post';
    }

    public function description(): ?string
    {
        return 'Get involved with the game by writing your first story post.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.posts.create');
    }
}
