<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding\NewUser;

use Illuminate\Support\Facades\Auth;
use Nova\Onboarding\Onboarding\OnboardingChecklistStep;

class AddUserPhoto extends OnboardingChecklistStep
{
    public function isComplete(): bool
    {
        return Auth::user()->hasMedia('avatar');
    }

    public function label(): string
    {
        return 'Upload a user photo';
    }

    public function description(): ?string
    {
        return 'You can upload a photo for your user account to make it easier for admins and other users to identify you throughout Nova as well as when you are a user author on a post.';
    }

    public function linkUrl(): ?string
    {
        return route('admin.account.edit');
    }
}
